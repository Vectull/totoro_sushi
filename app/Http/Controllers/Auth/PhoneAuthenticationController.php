<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\SmsRuService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PhoneAuthenticationController extends Controller
{
    public function sendCode(Request $request, SmsRuService $sms): RedirectResponse
    {
        $data = $request->validate([
            'phone' => ['required', 'string', 'max:32'],
            'name' => ['nullable', 'string', 'max:255'],
        ]);
        $phone = $this->normalizeRussianPhone($data['phone']);

        if ($phone === null) {
            return back()->withErrors(['phone' => 'Введите российский номер в формате +7 900 000-00-00.']);
        }

        if (! config('services.sms_ru.api_id')) {
            return back()->withErrors(['phone' => 'Регистрация по телефону пока не подключена: укажите SMSRU_API_ID в .env.']);
        }

        $code = (string) random_int(100000, 999999);
        $cachedVerification = Cache::get($this->cacheKey($phone));
        $name = trim((string) ($data['name'] ?? $request->session()->get('phone_auth_pending_name', '')));
        if ($name === '' && is_array($cachedVerification)) {
            $name = (string) ($cachedVerification['name'] ?? '');
        }

        try {
            $sms->sendVerificationCode($phone, $code);
        } catch (\Throwable $exception) {
            report($exception);

            return back()->withErrors(['phone' => 'Не удалось отправить SMS. Проверьте настройки SMS-провайдера и повторите попытку.']);
        }

        Cache::put($this->cacheKey($phone), [
            'hash' => Hash::make($code),
            'attempts' => 0,
            'name' => $name,
        ], now()->addMinutes(5));

        $request->session()->put('phone_auth_pending', $phone);
        $request->session()->put('phone_auth_pending_name', $name);

        return redirect()->route('phone-auth.verify.form')->with('status', 'Код отправлен. Он действует 5 минут.');
    }

    public function showVerification(Request $request): View|RedirectResponse
    {
        if (! $request->session()->has('phone_auth_pending')) {
            return redirect()->route('register');
        }

        return view('auth.phone-verify');
    }

    public function verifyCode(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'code' => ['required', 'digits:6'],
        ]);
        $phone = $request->session()->get('phone_auth_pending');
        $verification = is_string($phone) ? Cache::get($this->cacheKey($phone)) : null;

        if (! is_array($verification) || ! isset($verification['hash'])) {
            return redirect()->route('phone-auth.verify.form')->withErrors(['code' => 'Срок действия кода истёк. Запросите новый код.']);
        }

        if (($verification['attempts'] ?? 0) >= 5) {
            Cache::forget($this->cacheKey($phone));
            $request->session()->forget('phone_auth_pending');
            $request->session()->forget('phone_auth_pending_name');

            return redirect()->route('register')->withErrors(['code' => 'Превышено число попыток. Запросите новый код.']);
        }

        if (! Hash::check($data['code'], $verification['hash'])) {
            $verification['attempts']++;
            Cache::put($this->cacheKey($phone), $verification, now()->addMinutes(5));

            return back()->withErrors(['code' => 'Неверный код. Проверьте SMS и попробуйте ещё раз.']);
        }

        $user = User::query()->where('phone', $phone)->first();

        if (! $user) {
            $user = User::create([
                'name' => $verification['name'] !== '' ? $verification['name'] : 'Клиент',
                'phone' => $phone,
                'phone_verified_at' => now(),
                'password' => Str::random(64),
                'role' => UserRole::Customer,
            ]);
        } elseif (! $user->phone_verified_at) {
            $user->forceFill(['phone_verified_at' => now()])->save();
        }

        Cache::forget($this->cacheKey($phone));
        $request->session()->forget(['phone_auth_pending', 'phone_auth_pending_name']);
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }

    private function normalizeRussianPhone(string $phone): ?string
    {
        $digits = preg_replace('/\D+/', '', $phone) ?? '';

        if (strlen($digits) === 10) {
            $digits = '7'.$digits;
        } elseif (strlen($digits) === 11 && str_starts_with($digits, '8')) {
            $digits = '7'.substr($digits, 1);
        }

        return strlen($digits) === 11 && str_starts_with($digits, '7')
            ? '+'.$digits
            : null;
    }

    private function cacheKey(string $phone): string
    {
        return 'phone-auth:'.hash('sha256', $phone);
    }
}

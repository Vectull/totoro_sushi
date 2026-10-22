<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirectResponse;

class VKontakteAuthenticationController extends Controller
{
    public function redirect(): SymfonyRedirectResponse|RedirectResponse
    {
        if (! config('services.vkontakte.client_id') || ! config('services.vkontakte.client_secret')) {
            return redirect()->route('login')->withErrors(['vk' => 'Вход через VK пока не настроен.']);
        }

        return Socialite::driver('vkontakte')->scopes(['email'])->redirect();
    }

    public function callback(): RedirectResponse
    {
        $vkUser = Socialite::driver('vkontakte')->user();
        $providerId = (string) $vkUser->getId();

        $account = SocialAccount::query()
            ->where('provider', 'vkontakte')
            ->where('provider_user_id', $providerId)
            ->with('user')
            ->first();

        if ($account) {
            $user = $account->user;
        } else {
            $email = $vkUser->getEmail();
            if ($email && User::query()->where('email', $email)->exists()) {
                $email = null;
            }

            $name = trim((string) $vkUser->getName());
            if ($name === '') {
                $name = trim((string) $vkUser->getNickname());
            }

            $user = DB::transaction(function () use ($email, $name, $providerId, $vkUser): User {
                $newUser = User::create([
                    'name' => $name !== '' ? $name : 'Пользователь VK',
                    'email' => $email ? Str::lower($email) : null,
                    'password' => Str::random(64),
                    'role' => UserRole::Customer,
                ]);

                $newUser->socialAccounts()->create([
                    'provider' => 'vkontakte',
                    'provider_user_id' => $providerId,
                    'email' => $vkUser->getEmail(),
                    'name' => $vkUser->getName(),
                    'avatar_url' => $vkUser->getAvatar(),
                ]);

                return $newUser;
            });
        }

        Auth::login($user);
        request()->session()->regenerate();

        return redirect()->intended(route('home'));
    }
}

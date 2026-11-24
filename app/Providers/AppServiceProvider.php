<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use SocialiteProviders\Manager\SocialiteWasCalled;
use SocialiteProviders\VKontakte\Provider as VKontakteProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        VerifyEmail::toMailUsing(fn (object $notifiable, string $url): MailMessage => (new MailMessage)
            ->subject('Подтвердите адрес электронной почты')
            ->greeting('Здравствуйте!')
            ->line('Чтобы завершить регистрацию, подтвердите адрес электронной почты.')
            ->action('Подтвердить почту', $url)
            ->line('Если вы не создавали аккаунт, просто проигнорируйте это письмо.')
            ->salutation('С уважением, команда '.config('app.name')));

        Gate::define('access-admin', fn (User $user): bool => $user->role?->canAccessAdmin() ?? false);
        Gate::define('view-order', fn (User $user, Order $order): bool => $order->user_id === $user->id);

        RateLimiter::for('login', function (Request $request): Limit {
            $email = Str::lower((string) $request->input('email'));

            return Limit::perMinute(5)->by($email.'|'.$request->ip());
        });

        RateLimiter::for('phone-auth-send', function (Request $request): Limit {
            $phone = preg_replace('/\D+/', '', (string) $request->input('phone')) ?? '';

            return Limit::perHour(5)->by($phone.'|'.$request->ip());
        });

        RateLimiter::for('phone-auth-verify', function (Request $request): Limit {
            $phone = (string) $request->session()->get('phone_auth_pending', '');

            return Limit::perMinute(10)->by($phone.'|'.$request->ip());
        });

        Event::listen(function (SocialiteWasCalled $event): void {
            $event->extendSocialite('vkontakte', VKontakteProvider::class);
        });
    }
}

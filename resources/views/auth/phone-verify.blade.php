<x-layouts.app :title="'Подтверждение телефона — ' . config('app.name')" metaRobots="noindex, nofollow">
    <section class="mx-auto max-w-md rounded-3xl bg-white p-6 shadow-sm ring-1 ring-stone-200 sm:p-8">
        <h1 class="text-2xl font-extrabold tracking-tight text-stone-950">{{ session('phone_auth_flow') === 'login' ? 'Вход по номеру телефона' : 'Подтвердите номер' }}</h1>
        <p class="mt-2 text-sm leading-6 text-stone-600">Введите шестизначный код из SMS на номер {{ session('phone_auth_pending') }}. Код действует 5 минут. Если аккаунта ещё нет, он будет создан автоматически.</p>
        @if (session('status'))
            <p class="mt-4 rounded-xl bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-900">{{ session('status') }}</p>
        @endif
        @error('phone')
            <p class="mt-4 rounded-xl bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-800">{{ $message }}</p>
        @enderror

        <form method="POST" action="{{ route('phone-auth.verify') }}" class="mt-6 space-y-5">
            @csrf
            <div>
                <label for="code" class="block text-sm font-bold text-stone-800">Код из SMS</label>
                <input id="code" name="code" type="text" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" required autocomplete="one-time-code" autofocus class="mt-2 w-full rounded-xl border border-stone-300 px-4 py-3 text-center text-2xl font-bold tracking-[0.4em] outline-none focus:border-emerald-700 focus:ring-2 focus:ring-emerald-700/20">
                @error('code') <p class="mt-2 text-sm text-rose-700">{{ $message }}</p> @enderror
            </div>
            <button type="submit" class="w-full rounded-xl bg-emerald-900 px-5 py-3.5 text-sm font-extrabold text-white transition hover:bg-emerald-800">Подтвердить и продолжить</button>
        </form>

        <form method="POST" action="{{ route('phone-auth.send') }}" class="mt-3">
            @csrf
            <input type="hidden" name="phone" value="{{ session('phone_auth_pending') }}">
            <input type="hidden" name="name" value="{{ session('phone_auth_pending_name') }}">
            <input type="hidden" name="flow" value="{{ session('phone_auth_flow', 'register') }}">
            <button type="submit" class="w-full rounded-xl px-5 py-3 text-sm font-bold text-emerald-900 hover:bg-emerald-50">Отправить новый код</button>
        </form>
        <a href="{{ session('phone_auth_flow') === 'login' ? route('phone-auth.form') : route('register') }}" class="mt-2 block text-center text-sm font-bold text-emerald-900 underline underline-offset-4">Изменить номер</a>
    </section>
</x-layouts.app>

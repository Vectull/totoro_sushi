<x-layouts.app :title="'Вход — ' . config('app.name')" metaRobots="noindex, nofollow">
    <section class="mx-auto max-w-md rounded-3xl bg-white p-6 shadow-sm ring-1 ring-stone-200 sm:p-8">
        <h1 class="text-2xl font-extrabold tracking-tight text-stone-950">Вход в аккаунт</h1>
        <p class="mt-2 text-sm leading-6 text-stone-600">Войдите, чтобы перейти к своим заказам и возможностям аккаунта.</p>
        @if ($errors->has('vk'))
            <p class="mt-4 rounded-xl bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-800">{{ $errors->first('vk') }}</p>
        @endif

        <form method="POST" action="{{ route('login.store') }}" class="mt-6 space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-sm font-bold text-stone-800">Электронная почта</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username" autofocus class="mt-2 w-full rounded-xl border border-stone-300 px-4 py-3 text-stone-900 outline-none transition focus:border-emerald-700 focus:ring-2 focus:ring-emerald-700/20">
                @error('email')
                    <p class="mt-2 text-sm font-medium text-rose-700">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-bold text-stone-800">Пароль</label>
                <input id="password" name="password" type="password" required autocomplete="current-password" class="mt-2 w-full rounded-xl border border-stone-300 px-4 py-3 text-stone-900 outline-none transition focus:border-emerald-700 focus:ring-2 focus:ring-emerald-700/20">
            </div>

            <label class="flex items-center gap-2 text-sm text-stone-700">
                <input type="checkbox" name="remember" value="1" class="rounded border-stone-300 text-emerald-800 focus:ring-emerald-700">
                Запомнить меня
            </label>

            <button type="submit" class="w-full rounded-xl bg-emerald-900 px-5 py-3.5 text-sm font-extrabold text-white transition hover:bg-emerald-800">Войти</button>
        </form>

        <a href="{{ route('auth.vk.redirect') }}" class="mt-4 flex items-center justify-center gap-3 rounded-xl bg-[#0077FF] px-5 py-3.5 text-sm font-extrabold text-white transition hover:bg-[#0066DD]"><span class="font-black" aria-hidden="true">VK</span>Войти через VK</a>
        @if (! config('services.vkontakte.client_id'))
            <p class="mt-2 text-center text-xs text-stone-500">Для VK-входа настройте VKONTAKTE_CLIENT_ID и VKONTAKTE_CLIENT_SECRET в .env.</p>
        @endif

        <p class="mt-6 text-center text-sm text-stone-600">Нет аккаунта? <a href="{{ route('register') }}" class="font-bold text-emerald-900 underline underline-offset-4">Зарегистрироваться</a></p>
        <p class="mt-3 text-center text-sm text-stone-600">Войти по номеру? <a href="{{ route('register') }}" class="font-bold text-emerald-900 underline underline-offset-4">Получить SMS-код</a></p>
    </section>
</x-layouts.app>

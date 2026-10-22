<x-layouts.app :title="'Регистрация — ' . config('app.name')" metaRobots="noindex, nofollow">
    <div class="mx-auto max-w-3xl space-y-6">
        <header class="text-center">
            <h1 class="text-3xl font-extrabold tracking-tight text-stone-950">Создать аккаунт</h1>
            <p class="mt-2 text-stone-600">Зарегистрируйтесь по email, телефону или через VK.</p>
        </header>

        @if (session('status'))
            <p class="rounded-xl bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-900">{{ session('status') }}</p>
        @endif
        @if ($errors->has('vk'))
            <p class="rounded-xl bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-800">{{ $errors->first('vk') }}</p>
        @endif

        <div class="grid gap-6 md:grid-cols-2">
            <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-stone-200 sm:p-8">
                <h2 class="text-xl font-extrabold text-stone-950">По электронной почте</h2>
                <form method="POST" action="{{ route('register.store') }}" class="mt-5 space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-bold text-stone-800">Имя</label>
                        <input id="name" name="name" value="{{ old('name') }}" required autocomplete="name" class="mt-2 w-full rounded-xl border border-stone-300 px-4 py-3 outline-none focus:border-emerald-700 focus:ring-2 focus:ring-emerald-700/20">
                        @error('name') <p class="mt-1 text-sm text-rose-700">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-bold text-stone-800">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" class="mt-2 w-full rounded-xl border border-stone-300 px-4 py-3 outline-none focus:border-emerald-700 focus:ring-2 focus:ring-emerald-700/20">
                        @error('email') <p class="mt-1 text-sm text-rose-700">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-bold text-stone-800">Пароль</label>
                        <input id="password" name="password" type="password" required minlength="8" autocomplete="new-password" class="mt-2 w-full rounded-xl border border-stone-300 px-4 py-3 outline-none focus:border-emerald-700 focus:ring-2 focus:ring-emerald-700/20">
                        @error('password') <p class="mt-1 text-sm text-rose-700">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-stone-800">Повторите пароль</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required minlength="8" autocomplete="new-password" class="mt-2 w-full rounded-xl border border-stone-300 px-4 py-3 outline-none focus:border-emerald-700 focus:ring-2 focus:ring-emerald-700/20">
                    </div>
                    <button type="submit" class="w-full rounded-xl bg-emerald-900 px-5 py-3.5 text-sm font-extrabold text-white transition hover:bg-emerald-800">Зарегистрироваться</button>
                </form>
            </section>

            <section class="space-y-6">
                <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-stone-200 sm:p-8">
                    <h2 class="text-xl font-extrabold text-stone-950">По номеру телефона</h2>
                    <p class="mt-2 text-sm leading-6 text-stone-600">Пришлём код для подтверждения номера. Если аккаунт уже есть, код выполнит вход.</p>
                    <form method="POST" action="{{ route('phone-auth.send') }}" class="mt-5 space-y-4">
                        @csrf
                        <div>
                            <label for="phone-name" class="block text-sm font-bold text-stone-800">Имя</label>
                            <input id="phone-name" name="name" value="{{ old('name') }}" autocomplete="name" class="mt-2 w-full rounded-xl border border-stone-300 px-4 py-3 outline-none focus:border-emerald-700 focus:ring-2 focus:ring-emerald-700/20">
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-bold text-stone-800">Номер телефона</label>
                            <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" placeholder="+7 900 000-00-00" required autocomplete="tel" class="mt-2 w-full rounded-xl border border-stone-300 px-4 py-3 outline-none focus:border-emerald-700 focus:ring-2 focus:ring-emerald-700/20">
                            @error('phone') <p class="mt-1 text-sm text-rose-700">{{ $message }}</p> @enderror
                        </div>
                        <button type="submit" class="w-full rounded-xl border border-emerald-900 px-5 py-3.5 text-sm font-extrabold text-emerald-950 transition hover:bg-emerald-50">Получить код по SMS</button>
                    </form>
                </div>

                <a href="{{ route('auth.vk.redirect') }}" class="flex items-center justify-center gap-3 rounded-2xl bg-[#0077FF] px-5 py-4 font-bold text-white transition hover:bg-[#0066DD]"><span class="text-lg font-black" aria-hidden="true">VK</span>Продолжить через VK</a>
                @if (! config('services.vkontakte.client_id'))
                    <p class="-mt-4 text-sm leading-6 text-stone-500">Для VK-входа задайте VKONTAKTE_CLIENT_ID и VKONTAKTE_CLIENT_SECRET в .env.</p>
                @endif
            </section>
        </div>

        <p class="text-center text-sm text-stone-600">Уже зарегистрированы? <a href="{{ route('login') }}" class="font-bold text-emerald-900 underline underline-offset-4">Войти</a></p>
    </div>
</x-layouts.app>

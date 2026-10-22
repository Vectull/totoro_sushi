<x-layouts.app :title="($flow === 'register' ? 'Регистрация по телефону — ' : 'Вход по телефону — ') . config('app.name')" metaRobots="noindex, nofollow">
    <section class="mx-auto max-w-md rounded-3xl bg-white p-6 shadow-sm ring-1 ring-stone-200 sm:p-8">
        <h1 class="text-2xl font-extrabold tracking-tight text-stone-950">{{ $flow === 'register' ? 'Регистрация по телефону' : 'Вход по номеру телефона' }}</h1>
        <p class="mt-2 text-sm leading-6 text-stone-600">Отправим SMS с кодом подтверждения. {{ $flow === 'register' ? 'Если аккаунт уже есть, вы войдёте в него.' : 'Если аккаунта ещё нет, он создастся автоматически.' }}</p>

        <form method="POST" action="{{ route('phone-auth.send') }}" class="mt-6 space-y-5">
            @csrf
            <input type="hidden" name="flow" value="{{ $flow }}">
            @if ($flow === 'register')
                <div>
                    <label for="name" class="block text-sm font-bold text-stone-800">Имя</label>
                    <input id="name" name="name" value="{{ old('name') }}" autocomplete="name" class="mt-2 w-full rounded-xl border border-stone-300 px-4 py-3 text-stone-900 outline-none transition focus:border-emerald-700 focus:ring-2 focus:ring-emerald-700/20">
                    @error('name') <p class="mt-2 text-sm font-medium text-rose-700">{{ $message }}</p> @enderror
                </div>
            @endif
            <div>
                <label for="phone" class="block text-sm font-bold text-stone-800">Номер телефона</label>
                <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" placeholder="+7 900 000-00-00" required autocomplete="tel" autofocus class="mt-2 w-full rounded-xl border border-stone-300 px-4 py-3 text-stone-900 outline-none transition focus:border-emerald-700 focus:ring-2 focus:ring-emerald-700/20">
                @error('phone') <p class="mt-2 text-sm font-medium text-rose-700">{{ $message }}</p> @enderror
            </div>
            <button type="submit" class="w-full rounded-xl bg-emerald-900 px-5 py-3.5 text-sm font-extrabold text-white transition hover:bg-emerald-800">Получить код по SMS</button>
        </form>

        @if (! config('services.sms_ru.api_id'))
            <p class="mt-3 text-center text-xs text-stone-500">Для регистрации и входа по телефону необходимо настроить SMSRU_API_ID в .env.</p>
        @endif
        <p class="mt-6 text-center text-sm text-stone-600">Другой способ? <a href="{{ $flow === 'register' ? route('register') : route('login') }}" class="font-bold text-emerald-900 underline underline-offset-4">{{ $flow === 'register' ? 'Регистрация по email или через VK' : 'Войти по email или через VK' }}</a></p>
    </section>
</x-layouts.app>

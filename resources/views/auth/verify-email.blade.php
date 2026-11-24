<x-layouts.app :title="'Подтверждение почты — ' . config('app.name')" metaRobots="noindex, nofollow">
    <section class="mx-auto max-w-md rounded-3xl bg-white p-6 shadow-sm ring-1 ring-stone-200 sm:p-8">
        <h1 class="text-2xl font-extrabold tracking-tight text-stone-950">Подтвердите почту</h1>
        <p class="mt-2 text-sm leading-6 text-stone-600">Мы отправили письмо на {{ auth()->user()->email }}. Перейдите по ссылке в письме, чтобы подтвердить адрес.</p>

        @if (session('status'))
            <p class="mt-4 rounded-xl bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-900">{{ session('status') }}</p>
        @endif

        <form method="POST" action="{{ route('verification.send') }}" class="mt-6">
            @csrf
            <button type="submit" class="w-full rounded-xl bg-emerald-900 px-5 py-3.5 text-sm font-extrabold text-white transition hover:bg-emerald-800">Отправить письмо повторно</button>
        </form>
        <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf
            <button type="submit" class="w-full rounded-xl px-5 py-3 text-sm font-bold text-stone-700 transition hover:bg-stone-50">Выйти из аккаунта</button>
        </form>
    </section>
</x-layouts.app>

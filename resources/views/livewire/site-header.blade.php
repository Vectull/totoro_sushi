<header class="sticky top-0 z-40 border-b border-stone-200/80 bg-stone-50/90 backdrop-blur">
    <div class="mx-auto flex h-20 w-full max-w-7xl items-center justify-between gap-6 px-4 sm:px-6 lg:px-8">

        <a
            href="{{ route('home') }}"
            wire:navigate
            class="flex items-center gap-3"
        >
            <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-900 text-2xl shadow-sm">
                🍣
            </span>

            <span>
                <span class="block text-lg font-black leading-none text-stone-900">
                    {{ config('app.name') }}
                </span>

                <span class="mt-1 block text-[11px] font-bold uppercase tracking-[0.18em] text-emerald-700">
                    sushi market
                </span>
            </span>
        </a>

        <nav class="hidden items-center gap-1 md:flex">
            <a
                href="{{ route('home') }}"
                wire:navigate
                class="rounded-xl px-4 py-2.5 text-sm font-bold text-stone-700 transition hover:bg-white hover:text-emerald-900"
            >
                Главная
            </a>

            <a
                href="{{ route('catalog') }}"
                wire:navigate
                class="rounded-xl px-4 py-2.5 text-sm font-bold text-stone-700 transition hover:bg-white hover:text-emerald-900"
            >
                Меню
            </a>

            <span class="rounded-xl px-4 py-2.5 text-sm font-bold text-stone-400">
                Доставка
            </span>

            <span class="rounded-xl px-4 py-2.5 text-sm font-bold text-stone-400">
                Контакты
            </span>
        </nav>

        <div class="flex items-center gap-2">

            <button
                type="button"
                class="hidden rounded-xl bg-white px-3 py-2.5 text-sm font-bold text-stone-700 ring-1 ring-stone-200 sm:block"
            >
                Войти
            </button>

            <a
                href="{{ route('cart') }}"
                wire:navigate
                class="relative flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-900 text-xl text-white shadow-sm transition hover:bg-emerald-800 active:scale-95"
                aria-label="Корзина"
            >
                🛒

                @if ($cartCount > 0)
                    <span class="absolute -right-1 -top-1 flex h-5 min-w-5 items-center justify-center rounded-full bg-rose-500 px-1 text-[10px] font-black text-white">
                        {{ $cartCount > 99 ? '99+' : $cartCount }}
                    </span>
                @endif
            </a>

        </div>
    </div>
</header>
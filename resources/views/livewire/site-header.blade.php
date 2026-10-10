<header class="sticky top-0 z-40 border-b border-stone-200/80 bg-stone-50/90 backdrop-blur">
    <div class="mx-auto flex h-20 w-full max-w-7xl items-center justify-between gap-6 px-4 sm:px-6 lg:px-8">

        <a
            href="{{ route('home') }}"
            wire:navigate
            class="flex items-center gap-3"
        >
            <img
                src="{{ asset('totoro.jpg') }}"
                alt="Totoro sushi"
                class="h-11 w-11 rounded-2xl object-cover shadow-sm"
            >

            <span>
                <span class="block text-lg font-black leading-none text-stone-900">
                    Totoro sushi
                </span>

                <span class="mt-1 block text-[11px] font-bold uppercase tracking-[0.18em] text-emerald-700">
                    Суши · Роллы · Сеты
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

            <a
                href="{{ route('checkout') }}"
                wire:navigate
                class="rounded-xl px-4 py-2.5 text-sm font-bold text-stone-700 transition hover:bg-white hover:text-emerald-900"
            >
                Доставка
            </a>

            <a
                href="{{ route('contacts') }}"
                wire:navigate
                class="rounded-xl px-4 py-2.5 text-sm font-bold text-stone-700 transition hover:bg-white hover:text-emerald-900"
            >
                Контакты
            </a>
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
                class="relative flex h-11 min-w-11 items-center justify-center rounded-2xl bg-emerald-900 px-3 text-xl text-white shadow-sm transition hover:bg-emerald-800 active:scale-95"
                aria-label="Открыть корзину"
            >
                🛒

                <span
                    class="absolute -right-2 -top-2 flex h-6 min-w-6 items-center justify-center rounded-full bg-rose-500 px-1.5 text-[11px] font-black text-white shadow-sm"
                >
                    {{ $cartCount > 99 ? '99+' : $cartCount }}
                </span>
            </a>

        </div>
    </div>
</header>
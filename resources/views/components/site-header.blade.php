<header class="sticky top-0 z-40 border-b border-stone-200/80 bg-stone-50/95 backdrop-blur">
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">

        <a
            href="{{ route('home') }}"
            class="text-xl font-bold tracking-tight text-stone-950 transition hover:text-rose-600"
        >
            {{ config('app.name') }}
        </a>

        <nav
            class="hidden items-center gap-8 text-sm font-medium md:flex"
            aria-label="Основная навигация"
        >
            <a
                href="{{ route('home') }}"
                class="text-stone-700 transition hover:text-rose-600"
            >
                Главная
            </a>

            <a
                href="{{ route('catalog') }}"
                class="text-stone-700 transition hover:text-rose-600"
            >
                Меню
            </a>

            <a
                href="#"
                class="text-stone-700 transition hover:text-rose-600"
            >
                Доставка
            </a>

            <a
                href="#"
                class="text-stone-700 transition hover:text-rose-600"
            >
                Контакты
            </a>
        </nav>

        <a
            href="{{ route('catalog') }}"
            class="hidden rounded-full bg-rose-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-rose-700 hover:shadow md:inline-flex"
        >
            Смотреть меню
        </a>

        <details class="relative md:hidden">
            <summary
                class="cursor-pointer list-none rounded-lg border border-stone-300 bg-white px-3 py-2 text-sm font-medium text-stone-800 shadow-sm"
            >
                Меню
            </summary>

            <nav
                class="absolute right-0 z-50 mt-3 w-52 rounded-xl border border-stone-200 bg-white p-2 shadow-xl"
                aria-label="Мобильная навигация"
            >
                <a
                    href="{{ route('home') }}"
                    class="block rounded-lg px-3 py-2.5 text-sm text-stone-700 hover:bg-stone-100"
                >
                    Главная
                </a>

                <a
                    href="{{ route('catalog') }}"
                    class="block rounded-lg px-3 py-2.5 text-sm text-stone-700 hover:bg-stone-100"
                >
                    Меню
                </a>

                <a
                    href="#"
                    class="block rounded-lg px-3 py-2.5 text-sm text-stone-700 hover:bg-stone-100"
                >
                    Доставка
                </a>

                <a
                    href="#"
                    class="block rounded-lg px-3 py-2.5 text-sm text-stone-700 hover:bg-stone-100"
                >
                    Контакты
                </a>
            </nav>
        </details>
    </div>
</header>
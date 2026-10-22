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
                href="{{ route('contacts') }}"
                wire:navigate
                class="rounded-xl px-4 py-2.5 text-sm font-bold text-stone-700 transition hover:bg-white hover:text-emerald-900"
            >
                Контакты
            </a>
        </nav>

        <div class="flex items-center gap-2">

        @if (session('last_order_id') && (session('last_order_token') || auth()->check()))
    <a
        href="{{ route('order.show', array_filter([
            'order' => session('last_order_id'),
            'token' => session('last_order_token'),
        ], fn ($value) => $value !== null)) }}"
        wire:navigate
        class="hidden rounded-xl bg-amber-100 px-3 py-2.5 text-sm font-bold text-amber-900 transition hover:bg-amber-200 sm:inline-flex"
    >
        📦 Отследить заказ
    </a>
@endif

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

            <details class="relative md:hidden">
                <summary
                    class="flex h-11 w-11 cursor-pointer list-none items-center justify-center rounded-2xl bg-white text-stone-800 ring-1 ring-stone-200 [&::-webkit-details-marker]:hidden"
                    aria-label="Открыть меню"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </summary>
                <nav aria-label="Мобильная навигация" class="absolute right-0 top-14 z-50 flex w-56 flex-col gap-1 rounded-2xl border border-stone-200 bg-white p-2 shadow-xl">
                    <a href="{{ route('home') }}" wire:navigate class="rounded-xl px-4 py-3 text-sm font-bold text-stone-700 hover:bg-stone-50">Главная</a>
                    <a href="{{ route('catalog') }}" wire:navigate class="rounded-xl px-4 py-3 text-sm font-bold text-stone-700 hover:bg-stone-50">Меню</a>
                    <a href="{{ route('contacts') }}" wire:navigate class="rounded-xl px-4 py-3 text-sm font-bold text-stone-700 hover:bg-stone-50">Контакты и доставка</a>
                    @if (session('last_order_id') && (session('last_order_token') || auth()->check()))
                        <a href="{{ route('order.show', array_filter(['order' => session('last_order_id'), 'token' => session('last_order_token')], fn ($value) => $value !== null)) }}" wire:navigate class="rounded-xl px-4 py-3 text-sm font-bold text-amber-800 hover:bg-amber-50">Отследить заказ</a>
                    @endif
                </nav>
            </details>

        </div>
    </div>
</header>

<div class="space-y-8">

    {{-- Заголовок --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-sm font-bold uppercase tracking-[0.16em] text-emerald-700">
                Ваш заказ
            </p>

            <h1 class="mt-1 text-3xl font-black tracking-tight text-stone-900">
                Корзина
            </h1>
        </div>

        @if ($items)
            <button
                type="button"
                wire:click="clear"
                wire:loading.attr="disabled"
                class="self-start rounded-xl px-4 py-2 text-sm font-bold text-rose-600 transition hover:bg-rose-50 disabled:opacity-50"
            >
                Очистить корзину
            </button>
        @endif
    </div>

    {{-- Сообщение --}}
    @if (session('cart_message'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-800">
            {{ session('cart_message') }}
        </div>
    @endif

    {{-- Пустая корзина --}}
    @if (empty($items))

        <div class="rounded-3xl border border-dashed border-stone-300 bg-white px-6 py-16 text-center shadow-sm">

            <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-emerald-50 text-4xl">
                🛒
            </div>

            <h2 class="mt-6 text-2xl font-black text-stone-900">
                Корзина пуста
            </h2>

            <p class="mx-auto mt-2 max-w-md text-stone-500">
                Добавьте что-нибудь вкусное из нашего меню.
            </p>

            <a
                href="{{ route('catalog') }}"
                wire:navigate
                class="mt-7 inline-flex rounded-2xl bg-emerald-900 px-6 py-3.5 font-bold text-white shadow-sm transition hover:bg-emerald-800 active:scale-95"
            >
                Перейти в меню
            </a>

        </div>

    @else

        <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_360px]">

            {{-- Товары --}}
            <div class="space-y-4">

                @foreach ($items as $key => $item)

                    <article
                        wire:key="cart-item-{{ $key }}"
                        class="rounded-3xl border border-stone-200 bg-white p-4 shadow-sm sm:p-5"
                    >
                        <div class="flex gap-4 sm:gap-5">

                            {{-- Изображение --}}
                            <div class="h-24 w-24 shrink-0 overflow-hidden rounded-2xl bg-stone-100 sm:h-32 sm:w-32">

                                @if ($item['image'])
                                    <img
                                        src="{{ asset('storage/' . $item['image']) }}"
                                        alt="{{ $item['name'] }}"
                                        class="h-full w-full object-cover"
                                    >
                                @else
                                    <div class="flex h-full w-full flex-col items-center justify-center text-stone-400">
                                        <span class="text-3xl">🍣</span>
                                        <span class="mt-1 text-[10px] font-semibold">
                                            Нет фото
                                        </span>
                                    </div>
                                @endif

                            </div>

                            {{-- Информация --}}
                            <div class="min-w-0 flex-1">

                                <div class="flex items-start justify-between gap-3">

                                    <div>
                                        <h2 class="font-black text-stone-900 sm:text-lg">
                                            {{ $item['name'] }}
                                        </h2>

                                        <p class="mt-1 text-sm text-stone-500">
                                            {{ number_format($item['unit_price'], 0, ',', ' ') }} ₽ / шт.
                                        </p>
                                    </div>

                                    <button
                                        type="button"
                                        wire:click="remove('{{ $key }}')"
                                        wire:loading.attr="disabled"
                                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl text-xl text-stone-400 transition hover:bg-rose-50 hover:text-rose-600 disabled:opacity-50"
                                        aria-label="Удалить товар"
                                        title="Удалить"
                                    >
                                        ×
                                    </button>

                                </div>

                                {{-- Добавки --}}
                                @if (! empty($item['modifiers']))
                                    <div class="mt-3 space-y-1">
                                        @foreach ($item['modifiers'] as $modifier)
                                            <div class="text-sm text-stone-500">
                                                {{ $modifier['name'] }}
                                                <span class="text-stone-400">
                                                    +{{ number_format($modifier['price'], 0, ',', ' ') }} ₽
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                {{-- Низ карточки --}}
                                <div class="mt-4 flex flex-wrap items-center justify-between gap-4">

                                    {{-- Количество --}}
                                    <div class="flex items-center rounded-xl border border-stone-200 bg-stone-50">

                                        <button
                                            type="button"
                                            wire:click="updateQuantity('{{ $key }}', {{ $item['quantity'] - 1 }})"
                                            wire:loading.attr="disabled"
                                            class="flex h-10 w-10 items-center justify-center rounded-l-xl text-lg font-bold text-stone-700 transition hover:bg-white disabled:opacity-50"
                                        >
                                            −
                                        </button>

                                        <span class="flex h-10 min-w-10 items-center justify-center border-x border-stone-200 bg-white text-sm font-black text-stone-900">
                                            {{ $item['quantity'] }}
                                        </span>

                                        <button
                                            type="button"
                                            wire:click="updateQuantity('{{ $key }}', {{ $item['quantity'] + 1 }})"
                                            wire:loading.attr="disabled"
                                            class="flex h-10 w-10 items-center justify-center rounded-r-xl text-lg font-bold text-stone-700 transition hover:bg-white disabled:opacity-50"
                                        >
                                            +
                                        </button>

                                    </div>

                                    {{-- Цена позиции --}}
                                    <div class="text-lg font-black text-stone-900">
                                        {{ number_format($item['unit_price'] * $item['quantity'], 0, ',', ' ') }} ₽
                                    </div>

                                </div>

                            </div>
                        </div>
                    </article>

                @endforeach

            </div>

            {{-- Итого --}}
            <aside class="h-fit lg:sticky lg:top-28">

                <div class="rounded-3xl border border-stone-200 bg-white p-6 shadow-sm">

                    <h2 class="text-xl font-black text-stone-900">
                        Ваш заказ
                    </h2>

                    <div class="mt-6 space-y-3 text-sm">

                        <div class="flex justify-between text-stone-500">
                            <span>Товары</span>
                            <span>{{ $count }} шт.</span>
                        </div>

                        <div class="flex justify-between text-stone-500">
                            <span>Стоимость товаров</span>
                            <span>
                                {{ number_format($total, 0, ',', ' ') }} ₽
                            </span>
                        </div>

                    </div>

                    <div class="my-5 border-t border-stone-200"></div>

                    <div class="flex items-end justify-between gap-4">
                        <span class="font-bold text-stone-700">
                            Итого
                        </span>

                        <span class="text-2xl font-black text-stone-900">
                            {{ number_format($total, 0, ',', ' ') }} ₽
                        </span>
                    </div>

                    <a
    href="{{ route('checkout') }}"
    wire:navigate
    class="mt-6 flex w-full items-center justify-center rounded-2xl bg-emerald-900 px-6 py-4 font-bold text-white shadow-sm transition hover:bg-emerald-800 active:scale-[0.98]"
>
    Оформить заказ
</a>

                    <a
                        href="{{ route('catalog') }}"
                        wire:navigate
                        class="mt-3 flex w-full items-center justify-center rounded-2xl px-6 py-3.5 text-sm font-bold text-emerald-800 transition hover:bg-emerald-50"
                    >
                        ← Продолжить покупки
                    </a>

                </div>

                <div class="mt-4 rounded-2xl bg-emerald-50 px-5 py-4 text-sm leading-5 text-emerald-900">
                    Доставка и оформление заказа будут доступны на следующем этапе.
                </div>

            </aside>

        </div>

    @endif

</div>
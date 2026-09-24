<div class="space-y-8">
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900">
            Корзина
        </h1>

        @if ($items)
            <button
                type="button"
                wire:click="clear"
                class="text-sm text-red-600 hover:text-red-700"
            >
                Очистить корзину
            </button>
        @endif
    </div>

    @if (session('cart_message'))
        <div class="rounded-2xl bg-green-50 px-4 py-3 text-green-700">
            {{ session('cart_message') }}
        </div>
    @endif

    @if (empty($items))
        <div class="rounded-3xl border border-dashed p-12 text-center">
            <h2 class="text-xl font-semibold text-gray-900">
                Корзина пуста
            </h2>

            <p class="mt-2 text-gray-500">
                Добавьте что-нибудь из каталога.
            </p>

            <a
                href="{{ route('catalog') }}"
                class="mt-6 inline-flex rounded-2xl bg-green-600 px-6 py-3 font-semibold text-white"
            >
                Перейти в каталог
            </a>
        </div>
    @else
        <div class="grid gap-8 lg:grid-cols-[1fr_360px]">
            <div class="space-y-4">
                @foreach ($items as $key => $item)
                    <div class="flex gap-4 rounded-3xl border p-4">
                        <div class="h-24 w-24 shrink-0 overflow-hidden rounded-2xl bg-gray-100">
                            @if ($item['image'])
                                <img
                                    src="{{ asset('storage/' . $item['image']) }}"
                                    alt="{{ $item['name'] }}"
                                    class="h-full w-full object-cover"
                                >
                            @endif
                        </div>

                        <div class="min-w-0 flex-1">
                            <h2 class="font-semibold text-gray-900">
                                {{ $item['name'] }}
                            </h2>

                            @if (! empty($item['modifiers']))
                                <div class="mt-1 text-sm text-gray-500">
                                    @foreach ($item['modifiers'] as $modifier)
                                        <div>
                                            {{ $modifier['name'] }}
                                            +{{ number_format($modifier['price'], 0, ',', ' ') }} ₽
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <div class="mt-3 flex items-center justify-between gap-4">
                                <div class="flex items-center rounded-xl border">
                                    <button
                                        type="button"
                                        wire:click="updateQuantity('{{ $key }}', {{ $item['quantity'] - 1 }})"
                                        class="px-3 py-2"
                                    >
                                        −
                                    </button>

                                    <span class="min-w-8 text-center">
                                        {{ $item['quantity'] }}
                                    </span>

                                    <button
                                        type="button"
                                        wire:click="updateQuantity('{{ $key }}', {{ $item['quantity'] + 1 }})"
                                        class="px-3 py-2"
                                    >
                                        +
                                    </button>
                                </div>

                                <div class="font-semibold">
                                    {{ number_format($item['unit_price'] * $item['quantity'], 0, ',', ' ') }} ₽
                                </div>
                            </div>
                        </div>

                        <button
                            type="button"
                            wire:click="remove('{{ $key }}')"
                            class="self-start text-gray-400 hover:text-red-600"
                            aria-label="Удалить"
                        >
                            ×
                        </button>
                    </div>
                @endforeach
            </div>

            <aside class="h-fit rounded-3xl border p-6">
                <h2 class="text-xl font-semibold">
                    Итого
                </h2>

                <div class="mt-4 flex justify-between text-gray-600">
                    <span>Товары</span>
                    <span>{{ $count }} шт.</span>
                </div>

                <div class="mt-2 flex justify-between text-xl font-bold">
                    <span>Сумма</span>
                    <span>{{ number_format($total, 0, ',', ' ') }} ₽</span>
                </div>

                <button
                    type="button"
                    disabled
                    class="mt-6 w-full cursor-not-allowed rounded-2xl bg-gray-200 px-6 py-4 font-semibold text-gray-500"
                >
                    Оформление заказа — следующим этапом
                </button>
            </aside>
        </div>
    @endif
</div>
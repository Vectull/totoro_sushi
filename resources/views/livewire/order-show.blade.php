<div class="space-y-8">

    <div>
        <p class="text-sm font-bold uppercase tracking-[0.16em] text-emerald-700">
            Заказ
        </p>

        <h1 class="mt-1 text-3xl font-black tracking-tight text-stone-900">
            Заказ №{{ $order->id }}
        </h1>

        <p class="mt-2 text-sm text-stone-500">
            {{ $order->created_at->format('d.m.Y в H:i') }}
        </p>
    </div>

    <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_360px]">

        <div class="space-y-6">

            {{-- Статус --}}
            <section class="rounded-3xl border border-stone-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-bold text-stone-500">
                    Статус заказа
                </p>

                <div class="mt-3 flex items-center gap-3">
                    <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-100 text-xl">
                        🍣
                    </span>

                    <div>
                        <p class="text-xl font-black text-stone-900">
                            {{ $order->status->label() }}
                        </p>

                        <p class="mt-1 text-sm text-stone-500">
                            Заказ принят и передан в работу.
                        </p>
                    </div>
                </div>
            </section>

            {{-- Состав --}}
            <section class="rounded-3xl border border-stone-200 bg-white p-6 shadow-sm">

                <h2 class="text-xl font-black text-stone-900">
                    Состав заказа
                </h2>

                <div class="mt-6 divide-y divide-stone-100">

                    @foreach ($order->items as $item)
                        <div class="flex gap-4 py-4 first:pt-0 last:pb-0">

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-lg">
                                🍣
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="flex justify-between gap-4">
                                    <div>
                                        <h3 class="font-bold text-stone-900">
                                            {{ $item->product_name }}
                                        </h3>

                                        <p class="mt-1 text-sm text-stone-500">
                                            {{ $item->quantity }} ×
                                            {{ number_format($item->unit_price, 0, ',', ' ') }} ₽
                                        </p>
                                    </div>

                                    <span class="shrink-0 font-bold text-stone-900">
                                        {{ number_format($item->total, 0, ',', ' ') }} ₽
                                    </span>
                                </div>

                                @if (! empty($item->modifiers))
                                    <div class="mt-2 space-y-1">
                                        @foreach ($item->modifiers as $modifier)
                                            <p class="text-sm text-stone-500">
                                                {{ $modifier['name'] }}
                                                +{{ number_format($modifier['price'], 0, ',', ' ') }} ₽
                                            </p>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                        </div>
                    @endforeach

                </div>
            </section>

            {{-- Доставка --}}
            <section class="rounded-3xl border border-stone-200 bg-white p-6 shadow-sm">

                <h2 class="text-xl font-black text-stone-900">
                    Доставка
                </h2>

                <div class="mt-5 space-y-4">

                    <div>
                        <p class="text-sm text-stone-500">
                            Получатель
                        </p>

                        <p class="mt-1 font-bold text-stone-900">
                            {{ $order->customer_name }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-stone-500">
                            Телефон
                        </p>

                        <p class="mt-1 font-bold text-stone-900">
                            {{ $order->customer_phone }}
                        </p>
                    </div>

                    @if ($order->customer_email)
                        <div>
                            <p class="text-sm text-stone-500">
                                Email
                            </p>

                            <p class="mt-1 font-bold text-stone-900">
                                {{ $order->customer_email }}
                            </p>
                        </div>
                    @endif

                    <div>
                        <p class="text-sm text-stone-500">
                            Адрес
                        </p>

                        <p class="mt-1 font-bold text-stone-900">
                            {{ $order->delivery_address }}
                        </p>
                    </div>

                    @if ($order->comment)
                        <div>
                            <p class="text-sm text-stone-500">
                                Комментарий
                            </p>

                            <p class="mt-1 text-stone-700">
                                {{ $order->comment }}
                            </p>
                        </div>
                    @endif

                </div>
            </section>

        </div>

        {{-- Итог --}}
        <aside class="h-fit lg:sticky lg:top-28">

            <div class="rounded-3xl border border-stone-200 bg-white p-6 shadow-sm">

                <h2 class="text-xl font-black text-stone-900">
                    Итого
                </h2>

                <div class="mt-6 space-y-3 text-sm">

                    <div class="flex justify-between text-stone-500">
                        <span>Товары</span>
                        <span>
                            {{ number_format($order->subtotal, 0, ',', ' ') }} ₽
                        </span>
                    </div>

                    <div class="flex justify-between text-stone-500">
                        <span>Доставка</span>
                        <span>
                            {{ number_format($order->delivery_cost, 0, ',', ' ') }} ₽
                        </span>
                    </div>

                    @if ((float) $order->discount > 0)
                        <div class="flex justify-between text-emerald-700">
                            <span>Скидка</span>
                            <span>
                                −{{ number_format($order->discount, 0, ',', ' ') }} ₽
                            </span>
                        </div>
                    @endif

                </div>

                <div class="my-5 border-t border-stone-200"></div>

                <div class="flex items-end justify-between gap-4">
                    <span class="font-bold text-stone-700">
                        Итого
                    </span>

                    <span class="text-2xl font-black text-stone-900">
                        {{ number_format($order->total, 0, ',', ' ') }} ₽
                    </span>
                </div>

                <div class="mt-5 rounded-2xl bg-amber-50 px-4 py-3 text-sm text-amber-800">
                    Оплата будет подключена следующим этапом.
                </div>

            </div>

            <a
                href="{{ route('catalog') }}"
                wire:navigate
                class="mt-4 flex w-full items-center justify-center rounded-2xl px-6 py-3.5 text-sm font-bold text-emerald-800 transition hover:bg-emerald-50"
            >
                ← Вернуться в меню
            </a>

        </aside>

    </div>

</div>
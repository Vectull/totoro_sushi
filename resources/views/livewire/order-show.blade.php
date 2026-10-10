<div class="space-y-8" wire:poll.5s="refreshOrder">

    {{-- Заголовок --}}
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

            {{-- Статус и этапы заказа --}}
            <section class="rounded-3xl border border-stone-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-bold text-stone-500">
                    Статус заказа
                </p>

                <div class="mt-3 flex items-center gap-3">
                    <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-100 text-xl">
                        @if ($order->status->value === 'cancelled')
                            ✕
                        @elseif ($order->status->value === 'delivered')
                            ✓
                        @else
                            🍣
                        @endif
                    </span>

                    <div>
                        <p class="text-xl font-black text-stone-900">
                            {{ $order->status->label() }}
                        </p>

                        <p class="mt-1 text-sm text-stone-500">
                            @switch($order->status->value)
                                @case('pending')
                                    Заказ создан и ожидает начала приготовления.
                                    @break

                                @case('preparing')
                                    Ресторан готовит ваш заказ.
                                    @break

                                @case('ready')
                                    Заказ готов к выдаче или отправке.
                                    @break

                                @case('courier')
                                    Ваш заказ передан курьеру.
                                    @break

                                @case('delivered')
                                    Заказ успешно доставлен. Приятного аппетита!
                                    @break

                                @case('cancelled')
                                    Этот заказ отменён.
                                    @break
                            @endswitch
                        </p>
                    </div>
                </div>

                @if ($order->status->value === 'cancelled')
                    <div class="mt-6 rounded-2xl bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                        Заказ отменён. Если у вас есть вопросы, свяжитесь с рестораном.
                    </div>
                @else
                    @php
                        $isPickup = $order->delivery_method?->value === 'pickup';

                        $steps = [
                            'preparing' => 'Готовится',
                            'ready' => $isPickup ? 'Готов к выдаче' : 'Готов к отправке',
                            'courier' => $isPickup ? 'Выдан' : 'Передан курьеру',
                            'delivered' => $isPickup ? 'Получен' : 'Доставлен',
                        ];

                        $currentStep = match ($order->status->value) {
                            'pending', 'preparing' => 0,
                            'ready' => 1,
                            'courier' => 2,
                            'delivered' => 3,
                            default => -1,
                        };
                    @endphp

                    <div class="mt-8 space-y-5">
                        @foreach (array_values($steps) as $index => $label)
                            <div class="flex items-start gap-3">
                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-sm font-bold
                                    {{ $index <= $currentStep
                                        ? 'bg-emerald-600 text-white'
                                        : 'bg-stone-100 text-stone-400' }}">
                                    @if ($index < $currentStep)
                                        ✓
                                    @else
                                        {{ $index + 1 }}
                                    @endif
                                </div>

                                <div class="pt-1">
                                    <p class="font-bold {{ $index <= $currentStep
                                        ? 'text-emerald-800'
                                        : 'text-stone-400' }}">
                                        {{ $label }}
                                    </p>

                                    @if ($index === $currentStep)
                                        <p class="mt-1 text-sm text-stone-500">
                                            Текущий этап заказа
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <p class="mt-6 text-xs text-stone-400">
                    Статус обновляется автоматически.
                </p>
            </section>

            {{-- Состав заказа --}}
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

                                @if (!empty($item->modifiers))
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

            {{-- Данные доставки --}}
            <section class="rounded-3xl border border-stone-200 bg-white p-6 shadow-sm">
                <h2 class="text-xl font-black text-stone-900">
                    {{ $order->delivery_method?->value === 'pickup' ? 'Самовывоз' : 'Доставка' }}
                </h2>

                <div class="mt-5 space-y-4">
                    <div>
                        <p class="text-sm text-stone-500">Получатель</p>
                        <p class="mt-1 font-bold text-stone-900">
                            {{ $order->customer_name }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-stone-500">Телефон</p>
                        <p class="mt-1 font-bold text-stone-900">
                            {{ $order->customer_phone }}
                        </p>
                    </div>

                    @if ($order->customer_email)
                        <div>
                            <p class="text-sm text-stone-500">Email</p>
                            <p class="mt-1 font-bold text-stone-900">
                                {{ $order->customer_email }}
                            </p>
                        </div>
                    @endif

                    @if ($order->delivery_address)
                        <div>
                            <p class="text-sm text-stone-500">Адрес</p>
                            <p class="mt-1 font-bold text-stone-900">
                                {{ $order->delivery_address }}
                            </p>
                        </div>
                    @endif

                    @if ($order->comment)
                        <div>
                            <p class="text-sm text-stone-500">Комментарий</p>
                            <p class="mt-1 text-stone-700">
                                {{ $order->comment }}
                            </p>
                        </div>
                    @endif
                </div>
            </section>

        </div>

        {{-- Итог заказа --}}
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
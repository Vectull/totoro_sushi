<div class="space-y-8">

    <div>
        <a
            href="{{ route('cart') }}"
            wire:navigate
            class="text-sm font-bold text-emerald-700 hover:text-emerald-800"
        >
            ← Вернуться в корзину
        </a>

        <h1 class="mt-3 text-3xl font-black tracking-tight text-stone-900">
            Оформление заказа
        </h1>

        <p class="mt-2 text-stone-500">
            Заполните данные для доставки.
        </p>
    </div>

    <form
        wire:submit="createOrder"
        class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_360px]"
    >

        <div class="space-y-6">

            <section class="rounded-3xl border border-stone-200 bg-white p-6 shadow-sm">
                <h2 class="text-xl font-black text-stone-900">
                    Контактные данные
                </h2>

                <div class="mt-6 space-y-5">

                    <div>
                        <label class="text-sm font-bold text-stone-700">
                            Имя
                        </label>

                        <input
                            type="text"
                            wire:model="customerName"
                            class="mt-2 w-full rounded-2xl border-stone-200 px-4 py-3 focus:border-emerald-700 focus:ring-emerald-700"
                            placeholder="Ваше имя"
                        >

                        @error('customerName')
                            <p class="mt-1 text-sm text-rose-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label class="text-sm font-bold text-stone-700">
                            Телефон
                        </label>

                        <input
                            type="tel"
                            wire:model="customerPhone"
                            class="mt-2 w-full rounded-2xl border-stone-200 px-4 py-3 focus:border-emerald-700 focus:ring-emerald-700"
                            placeholder="+7 900 000-00-00"
                        >

                        @error('customerPhone')
                            <p class="mt-1 text-sm text-rose-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label class="text-sm font-bold text-stone-700">
                            Email
                            <span class="font-normal text-stone-400">
                                — необязательно
                            </span>
                        </label>

                        <input
                            type="email"
                            wire:model="customerEmail"
                            class="mt-2 w-full rounded-2xl border-stone-200 px-4 py-3 focus:border-emerald-700 focus:ring-emerald-700"
                            placeholder="you@example.com"
                        >

                        @error('customerEmail')
                            <p class="mt-1 text-sm text-rose-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                </div>
            </section>

            <section class="rounded-3xl border border-stone-200 bg-white p-6 shadow-sm">
                <h2 class="text-xl font-black text-stone-900">
                    Доставка
                </h2>

                <div class="mt-6">
                    <label class="text-sm font-bold text-stone-700">
                        Адрес доставки
                    </label>

                    <textarea
                        wire:model="deliveryAddress"
                        rows="3"
                        class="mt-2 w-full rounded-2xl border-stone-200 px-4 py-3 focus:border-emerald-700 focus:ring-emerald-700"
                        placeholder="Улица, дом, квартира"
                    ></textarea>

                    @error('deliveryAddress')
                        <p class="mt-1 text-sm text-rose-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mt-5">
                    <label class="text-sm font-bold text-stone-700">
                        Комментарий
                        <span class="font-normal text-stone-400">
                            — необязательно
                        </span>
                    </label>

                    <textarea
                        wire:model="comment"
                        rows="3"
                        class="mt-2 w-full rounded-2xl border-stone-200 px-4 py-3 focus:border-emerald-700 focus:ring-emerald-700"
                        placeholder="Комментарий к заказу"
                    ></textarea>

                    @error('comment')
                        <p class="mt-1 text-sm text-rose-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </section>

        </div>

        <aside class="h-fit lg:sticky lg:top-28">
            <div class="rounded-3xl border border-stone-200 bg-white p-6 shadow-sm">

                <h2 class="text-xl font-black text-stone-900">
                    Ваш заказ
                </h2>

                <div class="mt-5 space-y-3">
                    @foreach ($items as $item)
                        <div class="flex justify-between gap-4 text-sm">
                            <span class="text-stone-600">
                                {{ $item['name'] }} × {{ $item['quantity'] }}
                            </span>

                            <span class="shrink-0 font-bold text-stone-900">
                                {{ number_format($item['unit_price'] * $item['quantity'], 0, ',', ' ') }} ₽
                            </span>
                        </div>
                    @endforeach
                </div>

                <div class="my-5 border-t border-stone-200"></div>

                <div class="flex justify-between text-sm text-stone-500">
                    <span>Товары</span>
                    <span>{{ $count }} шт.</span>
                </div>

                <div class="mt-3 flex items-end justify-between gap-4">
                    <span class="font-bold text-stone-700">
                        Итого
                    </span>

                    <span class="text-2xl font-black text-stone-900">
                        {{ number_format($total, 0, ',', ' ') }} ₽
                    </span>
                </div>

                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    class="mt-6 w-full rounded-2xl bg-emerald-900 px-6 py-4 font-bold text-white transition hover:bg-emerald-800 disabled:cursor-wait disabled:opacity-60"
                >
                    <span wire:loading.remove>
                        Создать заказ
                    </span>

                    <span wire:loading>
                        Создаём заказ...
                    </span>
                </button>

            </div>
        </aside>

    </form>

</div>
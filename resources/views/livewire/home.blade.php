<div>
    <section class="relative overflow-hidden">
        <div class="mx-auto max-w-7xl px-4 py-20 sm:px-6 sm:py-28 lg:px-8">
            <div class="max-w-3xl">
                <span
                    class="inline-flex items-center rounded-full border border-rose-200 bg-rose-50 px-3 py-1 text-sm font-medium text-rose-700"
                >
                    Свежие блюда · Доставка
                </span>

                <h1
                    class="mt-6 text-5xl font-bold tracking-tight text-stone-950 sm:text-6xl lg:text-7xl"
                >
                    Вкус, который
                    <span class="text-rose-600">хочется повторить.</span>
                </h1>

                <p class="mt-6 max-w-2xl text-lg leading-8 text-stone-600">
                    Выберите любимые блюда из меню и оформите заказ с доставкой.
                </p>

                <div class="mt-9 flex flex-wrap gap-4">
                    <a
                        href="{{ route('catalog') }}"
                        class="rounded-full bg-rose-600 px-7 py-3.5 text-sm font-semibold text-white shadow-lg shadow-rose-600/20 transition hover:bg-rose-700"
                    >
                        Перейти в меню
                    </a>

                    <a
                        href="{{ route('catalog') }}"
                        class="rounded-full border border-stone-300 bg-white px-7 py-3.5 text-sm font-semibold text-stone-800 transition hover:border-stone-400 hover:bg-stone-100"
                    >
                        Посмотреть блюда
                    </a>
                </div>
            </div>
        </div>

        <div
            class="pointer-events-none absolute -right-32 -top-32 -z-10 h-96 w-96 rounded-full bg-rose-100 blur-3xl"
        ></div>

        <div
            class="pointer-events-none absolute -bottom-40 left-1/3 -z-10 h-96 w-96 rounded-full bg-orange-100 blur-3xl"
        ></div>
    </section>

    <section class="border-y border-stone-200 bg-white">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 py-10 sm:grid-cols-3 sm:px-6 lg:px-8">
            <div>
                <div class="text-2xl font-bold text-stone-950">
                    Свежие блюда
                </div>

                <p class="mt-2 text-sm leading-6 text-stone-600">
                    Приготовление непосредственно перед заказом.
                </p>
            </div>

            <div>
                <div class="text-2xl font-bold text-stone-950">
                    Удобный заказ
                </div>

                <p class="mt-2 text-sm leading-6 text-stone-600">
                    Простой процесс выбора и оформления заказа.
                </p>
            </div>

            <div>
                <div class="text-2xl font-bold text-stone-950">
                    Доставка
                </div>

                <p class="mt-2 text-sm leading-6 text-stone-600">
                    Условия доставки будут настроены после получения бизнес-данных.
                </p>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wider text-rose-600">
                    Меню
                </p>

                <h2 class="mt-2 text-3xl font-bold tracking-tight text-stone-950">
                    Выберите блюдо
                </h2>
            </div>

            <a
                href="{{ route('catalog') }}"
                class="text-sm font-semibold text-rose-600 hover:text-rose-700"
            >
                Смотреть всё →
            </a>
        </div>
    </section>
</div>
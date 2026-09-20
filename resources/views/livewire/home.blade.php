<div class="space-y-16">
    <section class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-emerald-950 via-emerald-900 to-stone-900 px-6 py-12 text-white shadow-xl sm:px-10 lg:px-14 lg:py-16">
        <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-amber-300/20 blur-3xl"></div>
        <div class="absolute -bottom-24 -left-16 h-64 w-64 rounded-full bg-rose-300/20 blur-3xl"></div>

        <div class="relative grid items-center gap-10 lg:grid-cols-[1.05fr_.95fr]">
            <div class="max-w-2xl">
                <span class="inline-flex rounded-full bg-white/10 px-4 py-2 text-sm font-semibold ring-1 ring-white/15">
                    Суши · Роллы · Сеты
                </span>

                <h1 class="mt-5 text-4xl font-black tracking-tight sm:text-5xl lg:text-6xl">
                    Яркий вкус,<br>
                    который хочется повторить
                </h1>

                <p class="mt-5 max-w-xl text-base leading-7 text-emerald-50/80 sm:text-lg">
                    Выбирай любимые блюда в каталоге и собирай заказ под себя.
                </p>

                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('catalog') }}"
                       class="rounded-2xl bg-amber-300 px-6 py-3.5 font-bold text-stone-950 shadow-lg transition hover:-translate-y-0.5 hover:bg-amber-200">
                        Смотреть меню
                    </a>
                    <a href="#features"
                       class="rounded-2xl bg-white/10 px-6 py-3.5 font-bold text-white ring-1 ring-white/15 transition hover:bg-white/15">
                        Узнать больше
                    </a>
                </div>
            </div>

            <div class="relative mx-auto w-full max-w-lg">
                <div class="aspect-square rounded-[2rem] bg-gradient-to-br from-amber-100 via-rose-100 to-emerald-100 p-5 shadow-2xl">
                    <div class="flex h-full items-center justify-center rounded-[1.5rem] border-2 border-dashed border-emerald-900/15 bg-white/50">
                        <div class="text-center">
                            <div class="mx-auto flex h-32 w-32 items-center justify-center rounded-full bg-white text-7xl shadow-lg">
                                🍣
                            </div>
                            <p class="mt-5 text-xl font-black text-stone-800">Твой будущий заказ</p>
                            <p class="mt-2 text-sm text-stone-600">Здесь позже появится фирменная иллюстрация</p>
                        </div>
                    </div>
                </div>

                <div class="absolute -bottom-4 -left-4 rounded-2xl bg-white px-4 py-3 text-sm font-bold text-stone-800 shadow-xl">
                    🍙 Выбирай любимое
                </div>
                <div class="absolute -right-4 -top-4 rounded-2xl bg-rose-500 px-4 py-3 text-sm font-bold text-white shadow-xl">
                    🌸 Яркое настроение
                </div>
            </div>
        </div>
    </section>

    <section id="features">
        <div class="mb-7">
            <p class="text-sm font-bold uppercase tracking-[0.2em] text-emerald-700">Просто и удобно</p>
            <h2 class="mt-2 text-3xl font-black tracking-tight text-stone-900 sm:text-4xl">Всё для быстрого заказа</h2>
        </div>

        <div class="grid gap-5 md:grid-cols-3">
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-stone-200">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100 text-2xl">🍣</div>
                <h3 class="mt-5 text-xl font-extrabold">Понятное меню</h3>
                <p class="mt-2 leading-6 text-stone-600">Категории и карточки помогают быстро найти нужное блюдо.</p>
            </div>

            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-stone-200">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-rose-100 text-2xl">🌸</div>
                <h3 class="mt-5 text-xl font-extrabold">Яркий интерфейс</h3>
                <p class="mt-2 leading-6 text-stone-600">Тёплая палитра и мягкие формы создают характер бренда.</p>
            </div>

            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-stone-200">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-100 text-2xl">🛒</div>
                <h3 class="mt-5 text-xl font-extrabold">Удобный заказ</h3>
                <p class="mt-2 leading-6 text-stone-600">Каталог станет основным маршрутом от выбора блюда до корзины.</p>
            </div>
        </div>
    </section>

    <section class="overflow-hidden rounded-[2rem] bg-amber-100 px-6 py-10 sm:px-10">
        <div class="flex flex-col items-start justify-between gap-6 sm:flex-row sm:items-center">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-amber-800">Каталог</p>
                <h2 class="mt-2 text-3xl font-black text-stone-900">Готов выбрать роллы?</h2>
                <p class="mt-2 text-stone-700">Перейди в меню и посмотри доступные блюда.</p>
            </div>
            <a href="{{ route('catalog') }}"
               class="shrink-0 rounded-2xl bg-stone-900 px-6 py-3.5 font-bold text-white transition hover:bg-stone-800">
                Открыть каталог →
            </a>
        </div>
    </section>
</div>

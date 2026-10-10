<footer class="mt-auto border-t border-stone-200 bg-stone-900 text-stone-300">
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">

        <div class="grid gap-8 md:grid-cols-3">

            <div>
                <div class="flex items-center gap-3">
                    <img
                        src="{{ asset('totoro.jpg') }}"
                        alt="Totoro sushi"
                        class="h-10 w-10 rounded-xl object-cover shadow-sm"
                    >

                    <div>
                        <div class="font-black text-white">
                            Totoro sushi
                        </div>

                        <div class="text-xs font-bold uppercase tracking-[0.16em] text-emerald-400">
                            Суши · Роллы · Сеты
                        </div>
                    </div>
                </div>

                <p class="mt-4 max-w-sm text-sm leading-6 text-stone-400">
                    Заказывайте любимые блюда онлайн.
                    Выбирайте роллы, суши и сеты в нашем меню.
                </p>
            </div>

            <div>
                <h2 class="font-bold text-white">
                    Навигация
                </h2>

                <div class="mt-4 flex flex-col gap-2 text-sm">
                    <a
                        href="{{ route('home') }}"
                        wire:navigate
                        class="transition hover:text-white"
                    >
                        Главная
                    </a>

                    <a
                        href="{{ route('catalog') }}"
                        wire:navigate
                        class="transition hover:text-white"
                    >
                        Меню
                    </a>

                    <a
                        href="{{ route('cart') }}"
                        wire:navigate
                        class="transition hover:text-white"
                    >
                        Корзина
                    </a>
                </div>
            </div>

            <div>
                <h2 class="font-bold text-white">
                    Информация
                </h2>

                <p class="mt-4 text-sm leading-6 text-stone-400">
                    Условия доставки, способы оплаты и контакты
                    смотрите в соответствующих разделах сайта.
                </p>
            </div>

        </div>

        <div class="mt-10 border-t border-stone-700 pt-5 text-sm text-stone-500">
            © {{ now()->year }} Totoro sushi
        </div>

    </div>
</footer>
<header class="border-b border-stone-200 bg-white">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="text-xl font-bold tracking-tight text-stone-950">{{ config('app.name') }}</a>

        <nav class="hidden items-center gap-6 text-sm font-medium md:flex" aria-label="Основная навигация">
            <a href="{{ route('home') }}" class="hover:text-rose-600">Главная</a>
            <a href="#" class="hover:text-rose-600">Меню</a>
            <a href="#" class="hover:text-rose-600">Доставка</a>
            <a href="#" class="hover:text-rose-600">Контакты</a>
        </nav>

        <details class="relative md:hidden">
            <summary class="cursor-pointer list-none rounded-md border border-stone-300 px-3 py-2 text-sm font-medium">Меню</summary>
            <nav class="absolute right-0 z-10 mt-2 w-48 rounded-md border border-stone-200 bg-white p-2 shadow-lg" aria-label="Мобильная навигация">
                <a href="{{ route('home') }}" class="block rounded px-3 py-2 hover:bg-stone-100">Главная</a>
                <a href="#" class="block rounded px-3 py-2 hover:bg-stone-100">Меню</a>
                <a href="#" class="block rounded px-3 py-2 hover:bg-stone-100">Доставка</a>
                <a href="#" class="block rounded px-3 py-2 hover:bg-stone-100">Контакты</a>
            </nav>
        </details>
    </div>
</header>

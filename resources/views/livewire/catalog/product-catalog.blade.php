<div>
    <section class="relative overflow-hidden rounded-[2rem] bg-gradient-to-r from-emerald-950 to-stone-900 px-6 py-10 text-white shadow-lg sm:px-10">
        <div class="absolute -right-10 -top-24 h-72 w-72 rounded-full bg-rose-400/15 blur-3xl"></div>
        <div class="absolute -bottom-24 left-1/3 h-64 w-64 rounded-full bg-amber-300/10 blur-3xl"></div>
        <div class="relative">
            <p class="text-sm font-bold uppercase tracking-[0.2em] text-amber-300">Меню</p>
            <h1 class="mt-2 text-4xl font-black tracking-tight sm:text-5xl">Выбирай любимое</h1>
            <p class="mt-3 max-w-2xl text-emerald-50/75">Каталог блюд с понятными категориями и крупными карточками.</p>
        </div>
    </section>

    <section class="mt-8">
        <div class="flex gap-2 overflow-x-auto pb-2">
            <button type="button" wire:click="selectCategory(null)"
                class="shrink-0 rounded-full px-5 py-2.5 text-sm font-bold transition {{ $selectedCategory === null ? 'bg-emerald-900 text-white shadow-md' : 'bg-white text-stone-700 ring-1 ring-stone-200 hover:bg-stone-50' }}">
                Все блюда
            </button>

            @foreach ($categories as $category)
                <button type="button" wire:click="selectCategory({{ $category->id }})"
                    class="shrink-0 rounded-full px-5 py-2.5 text-sm font-bold transition {{ $selectedCategory === $category->id ? 'bg-emerald-900 text-white shadow-md' : 'bg-white text-stone-700 ring-1 ring-stone-200 hover:bg-stone-50' }}">
                    {{ $category->name }}
                </button>
            @endforeach
        </div>
    </section>

    <section class="mt-8">
        <div class="mb-5 flex items-end justify-between gap-4">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.18em] text-rose-500">Каталог</p>
                <h2 class="mt-1 text-2xl font-black text-stone-900">Блюда</h2>
            </div>
            <div wire:loading class="text-sm font-semibold text-stone-500">Обновляем…</div>
        </div>

        @if ($products->count())
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
            <div class="mt-8">{{ $products->links() }}</div>
        @else
            <div class="rounded-3xl bg-white px-6 py-16 text-center shadow-sm ring-1 ring-stone-200">
                <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-full bg-amber-100 text-5xl">🍣</div>
                <h3 class="mt-5 text-xl font-black">Пока ничего не найдено</h3>
                <p class="mt-2 text-stone-600">Попробуй выбрать другую категорию.</p>
            </div>
        @endif
    </section>
</div>

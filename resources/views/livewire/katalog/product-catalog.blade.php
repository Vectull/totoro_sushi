<div
    class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8"
    x-on:product-modal-opened.window="document.documentElement.classList.add('overflow-hidden')"
    x-on:product-modal-closed.window="document.documentElement.classList.remove('overflow-hidden')"
    x-on:livewire:navigating.window="document.documentElement.classList.remove('overflow-hidden')"
>

    @include('livewire.katalog.partials.promotion-banner')

    <div class="mb-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">
            Каталог
        </h1>

        <p class="mt-2 text-gray-600">
            Выберите блюда из нашего меню.
        </p>

        @if ($categories->isNotEmpty())
            <div class="mt-6 flex flex-wrap gap-2">
                {{-- Все товары --}}
                <button
                    type="button"
                    wire:click="selectCategory(null)"
                    wire:loading.attr="disabled"
                    class="rounded-full px-4 py-2 text-sm font-bold transition
                        {{ $categoryId === null
                            ? 'bg-emerald-900 text-white shadow-sm'
                            : 'bg-white text-stone-700 ring-1 ring-stone-200 hover:bg-stone-100' }}"
                >
                    Все товары
                </button>

                {{-- Категории --}}
                @foreach ($categories as $category)
                    <button
                        type="button"
                        wire:click="selectCategory({{ $category->id }})"
                        wire:loading.attr="disabled"
                        class="rounded-full px-4 py-2 text-sm font-bold transition
                            {{ $categoryId === $category->id
                                ? 'bg-emerald-900 text-white shadow-sm'
                                : 'bg-white text-stone-700 ring-1 ring-stone-200 hover:bg-stone-100' }}"
                    >
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>
        @endif
    </div>

    @if ($products->isEmpty())
        <div class="rounded-2xl border border-dashed border-gray-300 p-12 text-center">
            <div class="mb-3 text-4xl">🍣</div>

            <p class="font-semibold text-gray-700">
                В этой категории пока нет товаров.
            </p>

            <button
                type="button"
                wire:click="selectCategory(null)"
                class="mt-4 font-semibold text-emerald-700 hover:text-emerald-800"
            >
                Показать все товары
            </button>
        </div>
    @else
        {{-- Сетка товаров --}}
        <div
            wire:loading.class="opacity-50"
            class="grid grid-cols-1 gap-6 transition-opacity sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"
        >
            @foreach ($products as $product)
                <button
                    type="button"
                    wire:click="openProduct({{ $product->id }})"
                    wire:key="product-{{ $product->id }}"
                    class="block w-full overflow-hidden rounded-xl border border-gray-200 bg-white text-left shadow-sm transition hover:-translate-y-1 hover:shadow-md"
                >
                    @if ($product->images->isNotEmpty())
                        <img
                            src="{{ asset('storage/' . ltrim($product->images->first()->path, '/')) }}"
                            alt="{{ $product->name }}"
                            class="h-56 w-full object-cover"
                        >
                    @else
                        <div class="flex h-56 items-center justify-center bg-gray-100 text-gray-400">
                            <div class="text-center">
                                <div class="mb-2 text-4xl">🍣</div>
                                <div class="text-sm font-medium">Нет изображения</div>
                            </div>
                        </div>
                    @endif

                    <div class="p-5">
                        @if ($product->category)
                            <div class="mb-2 text-sm text-gray-500">
                                {{ $product->category->name }}
                            </div>
                        @endif

                        <h2 class="text-lg font-semibold text-gray-900">
                            {{ $product->name }}
                        </h2>

                        @if ($product->description)
                            <p class="mt-2 line-clamp-2 text-sm text-gray-600">
                                {{ $product->description }}
                            </p>
                        @endif

                        <div class="mt-4 flex items-center justify-between gap-3">
                            <span class="text-lg font-bold text-gray-900">
                                {{ number_format($product->price, 2, ',', ' ') }} ₽
                            </span>

                            @if ($product->old_price)
                                <span class="text-sm text-gray-400 line-through">
                                    {{ number_format($product->old_price, 2, ',', ' ') }} ₽
                                </span>
                            @endif
                        </div>
                    </div>
                </button>
            @endforeach
        </div>

        {{-- Пагинация --}}
        <div class="mt-8">
            {{ $products->links() }}
        </div>

        {{-- Модальное окно товара --}}
        @if ($selectedProduct)
            @php
                $selectedModifiersTotal = $selectedProduct->productModifiers
                    ->filter(fn ($item) => in_array((int) $item->modifier_id, array_map('intval', $selectedModifiers), true) && $item->modifier?->is_active)
                    ->sum(fn ($item) => (float) $item->modifier->price);
                $selectedUnitPrice = (float) $selectedProduct->price + $selectedModifiersTotal;
                $availableModifiers = $selectedProduct->productModifiers
                    ->filter(fn ($item) => $item->modifier?->is_active && $item->modifier->slug !== 'chopsticks');
            @endphp

            <div
                class="fixed inset-0 z-50 flex items-start justify-center overflow-y-auto overscroll-contain bg-stone-950/65 p-3 backdrop-blur-sm sm:items-center sm:p-6"
                wire:click.self="closeProduct"
                wire:keydown.escape.window="closeProduct"
            >
                <section
                    role="dialog"
                    aria-modal="true"
                    aria-labelledby="product-dialog-title"
                    wire:key="product-dialog-{{ $selectedProduct->id }}"
                    class="flex h-[92vh] max-h-[900px] w-full max-w-5xl flex-col overflow-hidden rounded-3xl bg-white shadow-2xl"
                >
                    <div class="grid min-h-0 flex-1 grid-rows-[minmax(12rem,35vh)_minmax(0,1fr)] overflow-hidden md:grid-cols-2 md:grid-rows-1">
                        <div class="relative flex min-h-0 items-center justify-center overflow-hidden bg-stone-50">
                            @if ($selectedProduct->images->isNotEmpty())
                                <img
                                    src="{{ asset('storage/' . ltrim($selectedProduct->images->first()->path, '/')) }}"
                                    alt="{{ $selectedProduct->images->first()->alt ?: $selectedProduct->name }}"
                                    class="h-full w-full object-contain p-4 md:p-8"
                                >
                            @else
                                <div class="flex h-full w-full items-center justify-center text-7xl" aria-hidden="true">🍣</div>
                            @endif
                        </div>

                        <div class="product-modal-scrollbox min-h-0 overflow-y-auto overscroll-contain p-5 sm:p-8">
                            @if ($selectedProduct->category)
                                <p class="pr-12 text-sm font-semibold text-emerald-800">
                                    {{ $selectedProduct->category->name }}
                                </p>
                            @endif

                            <h2 id="product-dialog-title" class="mt-2 text-2xl font-extrabold tracking-tight text-gray-950 sm:text-3xl">
                                {{ $selectedProduct->name }}
                            </h2>

                            @if ($selectedProduct->weight || $selectedProduct->pieces)
                                <p class="mt-2 text-sm font-medium text-gray-500">
                                    @if ($selectedProduct->weight) {{ $selectedProduct->weight }} @endif
                                    @if ($selectedProduct->weight && $selectedProduct->pieces) <span class="mx-1">·</span> @endif
                                    @if ($selectedProduct->pieces) {{ $selectedProduct->pieces }} шт. @endif
                                </p>
                            @endif

                            @if ($selectedProduct->description)
                                <p class="mt-5 whitespace-pre-line text-sm leading-6 text-gray-600 sm:text-base">
                                    {{ $selectedProduct->description }}
                                </p>
                            @endif

                            @if ($selectedProduct->composition)
                                <details class="group mt-5 border-t border-gray-100 pt-4">
                                    <summary class="flex cursor-pointer list-none items-center justify-between gap-3 text-sm font-bold text-gray-900">
                                        <span>Состав</span>
                                        <span class="text-emerald-800 transition group-open:rotate-180" aria-hidden="true">⌄</span>
                                    </summary>
                                    <p class="mt-3 whitespace-pre-line text-sm leading-6 text-gray-600">
                                        {{ $selectedProduct->composition }}
                                    </p>
                                </details>
                            @endif

                            @if ($availableModifiers->isNotEmpty())
                                <section class="mt-5 border-t border-gray-100 pt-4" aria-labelledby="product-modifiers-heading">
                                    <h3 id="product-modifiers-heading" class="text-sm font-bold text-gray-900">Добавить к заказу</h3>
                                    <div class="mt-3 grid gap-2 sm:grid-cols-2">
                                        @foreach ($availableModifiers as $productModifier)
                                            <label wire:key="modifier-{{ $productModifier->modifier_id }}" class="flex cursor-pointer items-center justify-between gap-3 rounded-xl border border-gray-200 px-3 py-3 transition hover:border-emerald-300 has-[:checked]:border-emerald-700 has-[:checked]:bg-emerald-50">
                                                <span class="flex min-w-0 items-center gap-2">
                                                    <input
                                                        type="checkbox"
                                                        value="{{ $productModifier->modifier_id }}"
                                                        wire:model="selectedModifiers"
                                                        @disabled($productModifier->is_required)
                                                        class="rounded border-gray-300 text-emerald-800 focus:ring-emerald-700"
                                                    >
                                                    <span class="text-sm font-medium text-gray-800">
                                                        {{ $productModifier->modifier->name }}
                                                        @if ($productModifier->is_required)
                                                            <span class="block text-xs font-normal text-gray-500">Обязательно</span>
                                                        @endif
                                                    </span>
                                                </span>
                                                <span class="shrink-0 text-sm font-semibold text-gray-700">
                                                    @if ((float) $productModifier->modifier->price > 0)
                                                        +{{ number_format($productModifier->modifier->price, 0, ',', ' ') }} ₽
                                                    @else
                                                        Бесплатно
                                                    @endif
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                </section>
                            @endif

                            <div class="mt-6 flex flex-wrap items-end justify-between gap-4 border-t border-gray-100 pt-5">
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Количество</p>
                                    <div class="mt-2 inline-flex h-11 items-center rounded-full border border-gray-200 bg-white">
                                        <button type="button" wire:click="decreaseQuantity" wire:loading.attr="disabled" wire:target="decreaseQuantity,increaseQuantity,addToCart" @disabled($quantity <= 1) class="flex h-10 w-10 items-center justify-center rounded-full text-xl font-medium text-gray-700 transition hover:bg-gray-100 disabled:opacity-40" aria-label="Уменьшить количество">−</button>
                                        <span class="min-w-10 px-2 text-center text-base font-bold text-gray-900">{{ $quantity }}</span>
                                        <button type="button" wire:click="increaseQuantity" wire:loading.attr="disabled" wire:target="decreaseQuantity,increaseQuantity,addToCart" @disabled($quantity >= 99) class="flex h-10 w-10 items-center justify-center rounded-full text-xl font-medium text-gray-700 transition hover:bg-gray-100 disabled:opacity-40" aria-label="Увеличить количество">+</button>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Цена за штуку</p>
                                    <p class="mt-1 text-2xl font-extrabold tracking-tight text-gray-950">{{ number_format($selectedUnitPrice, 2, ',', ' ') }} ₽</p>
                                </div>
                            </div>

                            <button
                                type="button"
                                wire:click="addToCart"
                                wire:loading.attr="disabled"
                                wire:target="addToCart"
                                class="mt-5 flex min-h-14 w-full items-center justify-center rounded-2xl bg-emerald-900 px-5 py-4 font-bold text-white transition hover:bg-emerald-800 disabled:cursor-not-allowed disabled:opacity-50"
                            >
                                <span wire:loading.remove wire:target="addToCart">
                                    Добавить в корзину · {{ number_format($selectedUnitPrice * $quantity, 2, ',', ' ') }} ₽
                                </span>
                                <span wire:loading wire:target="addToCart">Добавляем...</span>
                            </button>

                            @error('selectedModifiers')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </section>
            </div>
        @endif
    @endif

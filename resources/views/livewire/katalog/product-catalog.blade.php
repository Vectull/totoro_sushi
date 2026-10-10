<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

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
                            src="{{ asset('storage/' . $product->images->first()->path) }}"
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
            <div
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4"
                wire:click.self="closeProduct"
                wire:keydown.escape.window="closeProduct"
            >
                <div class="relative max-h-[90vh] w-full max-w-2xl overflow-y-auto rounded-2xl bg-white shadow-2xl">
                    <button
                        type="button"
                        wire:click="closeProduct"
                        class="absolute right-3 top-3 z-10 flex h-10 w-10 items-center justify-center rounded-full bg-white text-2xl text-gray-700 shadow hover:bg-gray-100"
                        aria-label="Закрыть окно"
                    >
                        &times;
                    </button>

                    @if ($selectedProduct->images->isNotEmpty())
                        <img
                            src="{{ asset('storage/' . $selectedProduct->images->first()->path) }}"
                            alt="{{ $selectedProduct->name }}"
                            class="h-64 w-full object-cover sm:h-80"
                        >
                    @else
                        <div class="flex h-64 items-center justify-center bg-gray-100 text-5xl">
                            🍣
                        </div>
                    @endif

                    <div class="p-6">
                        @if ($selectedProduct->category)
                            <p class="text-sm font-medium text-emerald-700">
                                {{ $selectedProduct->category->name }}
                            </p>
                        @endif

                        <h2 class="mt-2 text-2xl font-bold text-gray-900">
                            {{ $selectedProduct->name }}
                        </h2>

                        @if ($selectedProduct->description)
                            <p class="mt-3 whitespace-pre-line text-gray-600">
                                {{ $selectedProduct->description }}
                            </p>
                        @endif

               <div class="mt-6 border-t border-gray-200 pt-5">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <p class="text-sm text-gray-500">Количество</p>

            <div class="mt-2 inline-flex items-center rounded-xl border border-gray-200 bg-white">
                <button
                    type="button"
                    wire:click="decreaseQuantity"
                    wire:loading.attr="disabled"
                    wire:target="decreaseQuantity,increaseQuantity,addToCart"
                    @disabled($quantity <= 1)
                    class="flex h-11 w-11 items-center justify-center rounded-l-xl text-xl font-bold text-gray-700 transition hover:bg-gray-100 disabled:cursor-not-allowed disabled:opacity-40"
                    aria-label="Уменьшить количество"
                >
                    −
                </button>

                <span class="min-w-12 px-3 text-center text-lg font-bold text-gray-900">
                    {{ $quantity }}
                </span>

                <button
                    type="button"
                    wire:click="increaseQuantity"
                    wire:loading.attr="disabled"
                    wire:target="decreaseQuantity,increaseQuantity,addToCart"
                    @disabled($quantity >= 99)
                    class="flex h-11 w-11 items-center justify-center rounded-r-xl text-xl font-bold text-gray-700 transition hover:bg-gray-100 disabled:cursor-not-allowed disabled:opacity-40"
                    aria-label="Увеличить количество"
                >
                    +
                </button>
            </div>
        </div>

        <div class="text-right">
            <p class="text-sm text-gray-500">Цена за штуку</p>
            <p class="mt-1 text-xl font-bold text-gray-900">
                {{ number_format($selectedProduct->price, 2, ',', ' ') }} ₽
            </p>
        </div>
    </div>

    <button
        type="button"
        wire:click="addToCart"
        wire:loading.attr="disabled"
        wire:target="addToCart"
        class="mt-5 flex w-full items-center justify-center rounded-xl bg-emerald-900 px-5 py-4 font-bold text-white transition hover:bg-emerald-800 disabled:cursor-not-allowed disabled:opacity-50"
    >
        <span wire:loading.remove wire:target="addToCart">
            Добавить в корзину · {{ number_format($selectedProduct->price * $quantity, 2, ',', ' ') }} ₽
        </span>

        <span wire:loading wire:target="addToCart">
            Добавляем...
        </span>
    </button>

    @error('selectedModifiers')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

                    </div>
                </div>
            </div>
        @endif
    @endif
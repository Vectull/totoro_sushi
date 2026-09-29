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
            <div class="mb-3 text-4xl">
                🍣
            </div>

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

        <div
            wire:loading.class="opacity-50"
            class="grid grid-cols-1 gap-6 transition-opacity sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"
        >

            @foreach ($products as $product)
                <a
                    href="{{ route('catalog.product', ['product' => $product->slug]) }}"
                    wire:navigate
                    class="block overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-md"
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
                                <div class="mb-2 text-4xl">
                                    🍣
                                </div>

                                <div class="text-sm font-medium">
                                    Нет изображения
                                </div>
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
                </a>
            @endforeach

        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>

    @endif

</div>
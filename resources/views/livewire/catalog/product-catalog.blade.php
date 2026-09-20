<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">
            Каталог
        </h1>

        <p class="mt-2 text-gray-600">
            Выберите блюда из нашего меню.
        </p>
    </div>

    @if ($products->isEmpty())
        <div class="rounded-lg border border-dashed border-gray-300 p-12 text-center">
            <p class="text-gray-500">
                Товары пока не добавлены.
            </p>
        </div>
    @else
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($products as $product)
                <article class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                    @if ($product->images->isNotEmpty())
                        <img
                            src="{{ asset('storage/' . $product->images->first()->path) }}"
                            alt="{{ $product->name }}"
                            class="h-56 w-full object-cover"
                        >
                    @else
                        <div class="flex h-56 items-center justify-center bg-gray-100 text-gray-400">
                            Нет изображения
                        </div>
                    @endif

                    <div class="p-5">
                        <div class="mb-2 text-sm text-gray-500">
                            {{ $product->category?->name }}
                        </div>

                        <h2 class="text-lg font-semibold text-gray-900">
                            {{ $product->name }}
                        </h2>

                        @if ($product->description)
                            <p class="mt-2 line-clamp-2 text-sm text-gray-600">
                                {{ $product->description }}
                            </p>
                        @endif

                        <div class="mt-4 flex items-center justify-between">
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
                </article>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    @endif
</div>
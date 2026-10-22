<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

    @if ($promotions->isNotEmpty())
        @php($bannerProduct = $promotions->get($bannerIndex))
        <section
            aria-label="Акции и специальные предложения"
            aria-roledescription="карусель"
            class="relative mb-10 overflow-hidden rounded-[2rem] bg-gradient-to-br from-emerald-950 via-emerald-900 to-stone-900 text-white shadow-xl"
        >
            <div class="pointer-events-none absolute -right-20 -top-24 h-72 w-72 rounded-full bg-amber-300/20 blur-3xl"></div>
            <div class="pointer-events-none absolute -bottom-28 left-1/3 h-64 w-64 rounded-full bg-rose-400/20 blur-3xl"></div>

            <div wire:key="promotion-banner-{{ $bannerProduct->id }}" class="relative grid min-h-72 items-center gap-8 px-8 py-10 sm:px-12 lg:grid-cols-[1.1fr_.9fr] lg:px-16">
                <div class="max-w-2xl pr-8 sm:pr-12">
                    <span class="inline-flex rounded-full bg-amber-300 px-3 py-1.5 text-xs font-black uppercase tracking-wider text-stone-950">
                        {{ $bannerProduct->discount_percent ? 'Скидка ' . rtrim(rtrim((string) $bannerProduct->discount_percent, '0'), '.') . '%' : 'Специальное предложение' }}
                    </span>

                    <h2 class="mt-4 text-3xl font-black tracking-tight sm:text-4xl lg:text-5xl">
                        {{ $bannerProduct->name }}
                    </h2>

                    <p class="mt-3 max-w-xl text-sm leading-6 text-emerald-50/80 sm:text-base">
                        {{ $bannerProduct->description ?: 'Попробуйте наше специальное предложение. Закажите сейчас с доставкой или самовывозом.' }}
                    </p>

                    <div class="mt-5 flex flex-wrap items-center gap-3">
                        <span class="text-2xl font-black">
                            {{ number_format($bannerProduct->price, 0, ',', ' ') }} ₽
                        </span>
                        @if ($bannerProduct->old_price)
                            <span class="text-base text-white/55 line-through">
                                {{ number_format($bannerProduct->old_price, 0, ',', ' ') }} ₽
                            </span>
                        @endif
                        <a
                            href="{{ route('catalog.product', ['product' => $bannerProduct->slug]) }}"
                            wire:navigate
                            class="rounded-xl bg-amber-300 px-5 py-3 text-sm font-extrabold text-stone-950 transition hover:-translate-y-0.5 hover:bg-amber-200"
                        >
                            Смотреть предложение
                        </a>
                    </div>
                </div>

                <div class="hidden h-52 items-center justify-center overflow-hidden rounded-3xl bg-white/10 ring-1 ring-white/15 sm:flex lg:h-60">
                    @if ($bannerProduct->images->isNotEmpty())
                        <img
                            src="{{ asset('storage/' . ltrim($bannerProduct->images->first()->path, '/')) }}"
                            alt="{{ $bannerProduct->name }}"
                            class="h-full w-full object-cover"
                        >
                    @else
                        <div class="text-8xl" aria-hidden="true">🍣</div>
                    @endif
                </div>
            </div>

            @if ($promotions->count() > 1)
                <button
                    type="button"
                    wire:click="previousBanner"
                    aria-label="Предыдущее предложение"
                    class="absolute left-3 top-1/2 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-black/25 text-white ring-1 ring-white/30 transition hover:bg-black/45 sm:left-5 sm:h-12 sm:w-12"
                >
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6" /></svg>
                </button>
                <button
                    type="button"
                    wire:click="nextBanner"
                    aria-label="Следующее предложение"
                    class="absolute right-3 top-1/2 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-black/25 text-white ring-1 ring-white/30 transition hover:bg-black/45 sm:right-5 sm:h-12 sm:w-12"
                >
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6" /></svg>
                </button>
            @endif

            @if ($promotions->count() > 1)
                <div class="relative flex justify-center gap-2 pb-5" aria-label="Выбрать предложение">
                    @foreach ($promotions as $index => $promotion)
                        <button
                            type="button"
                            wire:click="$set('bannerIndex', {{ $index }})"
                            aria-label="Предложение {{ $index + 1 }}"
                            @if ($index === $bannerIndex) aria-current="true" @endif
                            class="h-2.5 rounded-full transition-all {{ $index === $bannerIndex ? 'w-7 bg-amber-300' : 'w-2.5 bg-white/50 hover:bg-white/80' }}"
                        ></button>
                    @endforeach
                </div>
            @endif
        </section>
    @endif

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

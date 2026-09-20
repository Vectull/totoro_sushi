<div>
    <section class="relative overflow-hidden rounded-[2rem] bg-gradient-to-r from-emerald-950 to-stone-900 px-6 py-10 text-white sm:px-10">
        <div class="absolute -right-10 -top-24 h-72 w-72 rounded-full bg-rose-400/15 blur-3xl"></div>

        <div class="relative">
            <p class="text-sm font-bold uppercase tracking-[0.2em] text-amber-300">Меню</p>
            <h1 class="mt-2 text-4xl font-black tracking-tight sm:text-5xl">Каталог</h1>
            <p class="mt-3 max-w-2xl text-emerald-50/75">
                Выбирай блюда по категориям и открывай карточку понравившегося продукта.
            </p>
        </div>
    </section>

    <section class="mt-8">
        <div class="flex gap-2 overflow-x-auto pb-2">
            <button
                type="button"
                wire:click="selectCategory(null)"
                class="shrink-0 rounded-full px-5 py-2.5 text-sm font-bold transition
                    {{ $selectedCategory === null
                        ? 'bg-emerald-900 text-white shadow-md'
                        : 'bg-white text-stone-700 ring-1 ring-stone-200 hover:bg-stone-50' }}">
                Все блюда
            </button>

            @foreach ($categories as $category)
                <button
                    type="button"
                    wire:click="selectCategory({{ $category->id }})"
                    class="shrink-0 rounded-full px-5 py-2.5 text-sm font-bold transition
                        {{ $selectedCategory === $category->id
                            ? 'bg-emerald-900 text-white shadow-md'
                            : 'bg-white text-stone-700 ring-1 ring-stone-200 hover:bg-stone-50' }}">
                    {{ $category->name }}
                </button>
            @endforeach
        </div>
    </section>

    <section class="mt-8">
        <div class="mb-5 flex items-end justify-between gap-4">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.18em] text-rose-500">Меню</p>
                <h2 class="mt-1 text-2xl font-black text-stone-900">Блюда</h2>
            </div>

            <div wire:loading class="text-sm font-semibold text-stone-500">
                Обновляем…
            </div>
        </div>

        @if ($products->count())
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($products as $product)
                    <article wire:key="product-{{ $product->id }}"
                             class="group overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-stone-200 transition duration-200 hover:-translate-y-1 hover:shadow-xl">
                        <div class="relative aspect-[4/3] overflow-hidden bg-gradient-to-br from-amber-100 via-rose-50 to-emerald-100">
                            @if ($product->images->first())
                                <img
                                    src="{{ asset('storage/' . $product->images->first()->path) }}"
                                    alt="{{ $product->name }}"
                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                >
                            @else
                                <div class="flex h-full items-center justify-center text-6xl">🍣</div>
                            @endif

                            @if ($product->is_new)
                                <span class="absolute left-3 top-3 rounded-full bg-rose-500 px-3 py-1.5 text-xs font-extrabold text-white shadow">
                                    Новинка
                                </span>
                            @elseif ($product->is_popular)
                                <span class="absolute left-3 top-3 rounded-full bg-amber-300 px-3 py-1.5 text-xs font-extrabold text-stone-900 shadow">
                                    Популярное
                                </span>
                            @endif
                        </div>

                        <div class="p-5">
                            <p class="text-xs font-bold uppercase tracking-wider text-emerald-700">
                                {{ $product->category?->name }}
                            </p>

                            <h3 class="mt-1 text-lg font-black text-stone-900">
                                {{ $product->name }}
                            </h3>

                            @if ($product->description)
                                <p class="mt-2 line-clamp-2 text-sm leading-5 text-stone-600">
                                    {{ $product->description }}
                                </p>
                            @endif

                            <div class="mt-5 flex items-end justify-between gap-3">
                                <div>
                                    <div class="flex items-baseline gap-2">
                                        <span class="text-xl font-black text-stone-900">{{ $product->price }} ₽</span>
                                        @if ($product->old_price)
                                            <span class="text-sm text-stone-400 line-through">{{ $product->old_price }} ₽</span>
                                        @endif
                                    </div>

                                    @if ($product->weight || $product->pieces)
                                        <p class="mt-1 text-xs text-stone-500">
                                            {{ $product->weight ? $product->weight . ' г' : '' }}
                                            {{ $product->weight && $product->pieces ? ' · ' : '' }}
                                            {{ $product->pieces ? $product->pieces . ' шт.' : '' }}
                                        </p>
                                    @endif
                                </div>

                                <button
                                    type="button"
                                    class="rounded-2xl bg-emerald-900 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-emerald-800">
                                    Выбрать
                                </button>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @else
            <div class="rounded-3xl bg-white px-6 py-16 text-center shadow-sm ring-1 ring-stone-200">
                <div class="text-6xl">🍣</div>
                <h3 class="mt-5 text-xl font-black">Пока ничего не найдено</h3>
                <p class="mt-2 text-stone-600">Попробуй выбрать другую категорию.</p>
            </div>
        @endif
    </section>
</div>

@props(['product'])

<article wire:key="product-{{ $product->id }}"
    class="group overflow-hidden rounded-[1.75rem] bg-white shadow-sm ring-1 ring-stone-200/80 transition duration-300 hover:-translate-y-1 hover:shadow-xl">
    <div class="relative aspect-[4/3] overflow-hidden bg-gradient-to-br from-amber-100 via-rose-50 to-emerald-100">
        @if ($product->images->first())
            <img src="{{ asset('storage/' . $product->images->first()->path) }}"
                 alt="{{ $product->name }}"
                 loading="lazy"
                 class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
        @else
            <div class="relative flex h-full items-center justify-center overflow-hidden">
                <div class="absolute -left-8 -top-8 h-32 w-32 rounded-full bg-rose-300/30 blur-2xl"></div>
                <div class="absolute -bottom-10 -right-8 h-40 w-40 rounded-full bg-emerald-300/30 blur-2xl"></div>
                <div class="relative text-center">
                    <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-full bg-white/80 text-5xl shadow-lg">🍣</div>
                    <span class="mt-3 block text-xs font-bold uppercase tracking-wider text-stone-500">Фото скоро появится</span>
                </div>
            </div>
        @endif

        @if ($product->is_new)
            <span class="absolute left-3 top-3 rounded-full bg-rose-500 px-3 py-1.5 text-xs font-extrabold text-white shadow-md">Новинка</span>
        @elseif ($product->is_popular)
            <span class="absolute left-3 top-3 rounded-full bg-amber-300 px-3 py-1.5 text-xs font-extrabold text-stone-900 shadow-md">Популярное</span>
        @elseif ($product->is_promotion)
            <span class="absolute left-3 top-3 rounded-full bg-emerald-900 px-3 py-1.5 text-xs font-extrabold text-white shadow-md">Акция</span>
        @endif

        @if ($product->discount_percent)
            <span class="absolute right-3 top-3 rounded-full bg-white/95 px-3 py-1.5 text-xs font-black text-rose-600 shadow-md">
                -{{ $product->discount_percent }}%
            </span>
        @endif
    </div>

    <div class="p-5">
        @if ($product->category)
            <p class="text-[11px] font-extrabold uppercase tracking-[0.16em] text-emerald-700">{{ $product->category->name }}</p>
        @endif

        <h3 class="mt-1 truncate text-lg font-black text-stone-900" title="{{ $product->name }}">{{ $product->name }}</h3>

        @if ($product->description)
            <p class="mt-2 line-clamp-2 min-h-10 text-sm leading-5 text-stone-600">{{ $product->description }}</p>
        @endif

        @if ($product->composition)
            <p class="mt-2 line-clamp-1 text-xs text-stone-500">{{ $product->composition }}</p>
        @endif

        <div class="mt-5 flex items-end justify-between gap-3">
            <div>
                <div class="flex flex-wrap items-baseline gap-2">
                    <span class="text-xl font-black text-stone-900">{{ $product->price }} ₽</span>
                    @if ($product->old_price)
                        <span class="text-sm font-medium text-stone-400 line-through">{{ $product->old_price }} ₽</span>
                    @endif
                </div>

                @if ($product->weight || $product->pieces)
                    <p class="mt-1 text-xs font-medium text-stone-500">
                        @if ($product->weight) {{ $product->weight }} г @endif
                        @if ($product->weight && $product->pieces)<span class="mx-1">·</span>@endif
                        @if ($product->pieces) {{ $product->pieces }} шт. @endif
                    </p>
                @endif
            </div>

            <a
    href="{{ route('catalog.product', ['product' => $product->slug]) }}"
    class="shrink-0 rounded-2xl bg-emerald-900 px-4 py-2.5 text-sm font-extrabold text-white shadow-sm transition hover:bg-emerald-800 active:scale-95"
>
    Выбрать
</a>
        </div>
    </div>
</article>

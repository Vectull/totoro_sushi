<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

  @if (session()->has('cart_message'))
        <div
            class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-800"
        >
            {{ session('cart_message') }}
        </div>
    @endif


    <div class="mb-6">
        <a
            href="{{ route('catalog') }}"
            wire:navigate
            class="text-sm font-semibold text-emerald-700 hover:text-emerald-800"
        >
            ← Вернуться в каталог
        </a>
    </div>

    <div class="grid gap-8 lg:grid-cols-2">

        {{-- Изображение --}}
        <div class="overflow-hidden rounded-2xl bg-gray-100">
            @if ($product->images->isNotEmpty())
                <img
                    src="{{ asset('storage/' . $product->images->first()->path) }}"
                    alt="{{ $product->name }}"
                    class="aspect-square w-full object-cover"
                >
           @else
    <div class="flex aspect-square w-full items-center justify-center bg-gray-100 text-gray-400">
        <div class="text-center">
            <div class="mb-2 text-5xl">🍣</div>
            <div class="text-sm font-medium">
                Нет изображения
            </div>
        </div>
    </div>
@endif
        </div>

        {{-- Информация --}}
        <div>
            @if ($product->category)
                <div class="mb-2 text-sm font-medium text-gray-500">
                    {{ $product->category->name }}
                </div>
            @endif

            <h1 class="text-3xl font-bold text-gray-900">
                {{ $product->name }}
            </h1>

            @if ($product->description)
                <p class="mt-4 text-gray-600">
                    {{ $product->description }}
                </p>
            @endif

            @if ($product->composition)
                <div class="mt-6">
                    <h2 class="font-semibold text-gray-900">
                        Состав
                    </h2>

                    <p class="mt-2 text-gray-600">
                        {{ $product->composition }}
                    </p>
                </div>
            @endif

            <div class="mt-6">
                <span class="text-2xl font-bold text-gray-900">
                    {{ number_format($product->price, 2, ',', ' ') }} ₽
                </span>

                @if ($product->old_price)
                    <span class="ml-2 text-lg text-gray-400 line-through">
                        {{ number_format($product->old_price, 2, ',', ' ') }} ₽
                    </span>
                @endif
            </div>

            {{-- Добавки --}}
            @if ($product->productModifiers->isNotEmpty())
                <div class="mt-8">
                    <h2 class="mb-4 font-semibold text-gray-900">
                        Добавки
                    </h2>

                    <div class="space-y-3">
                        @foreach ($product->productModifiers as $productModifier)
                            @if ($productModifier->modifier?->is_active)
                                <label class="flex cursor-pointer items-center justify-between rounded-xl border border-gray-200 p-4">
                                    <div class="flex items-center gap-3">
                                        <input
                                            type="checkbox"
                                            value="{{ $productModifier->modifier_id }}"
                                            wire:model="selectedModifiers"
                                            class="rounded border-gray-300"
                                        >

                                        <span>
                                            {{ $productModifier->modifier->name }}

                                            @if ($productModifier->is_required)
                                                <span class="text-sm text-red-500">
                                                    обязательно
                                                </span>
                                            @endif
                                        </span>
                                    </div>

                                    <span class="font-medium">
                                        +{{ number_format($productModifier->modifier->price, 2, ',', ' ') }} ₽
                                    </span>
                                </label>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Количество --}}
            <div class="mt-8">
                <h2 class="mb-3 font-semibold text-gray-900">
                    Количество
                </h2>

                <div class="flex items-center gap-4">
                    <button
                        type="button"
                        wire:click="decreaseQuantity"
                        class="flex h-10 w-10 items-center justify-center rounded-full border border-gray-300 text-lg"
                    >
                        −
                    </button>

                    <span class="min-w-8 text-center text-lg font-semibold">
                        {{ $quantity }}
                    </span>

                    <button
                        type="button"
                        wire:click="increaseQuantity"
                        class="flex h-10 w-10 items-center justify-center rounded-full border border-gray-300 text-lg"
                    >
                        +
                    </button>
                </div>
            </div>

            {{-- Корзина --}}
            <div class="mt-8">
                <button
                    type="button"
                    wire:click="addToCart"
                    class="w-full rounded-xl bg-emerald-900 px-6 py-4 font-bold text-white transition hover:bg-emerald-800"
                >
                    Добавить в корзину
                </button>
            </div>

        </div>
    </div>
</div>
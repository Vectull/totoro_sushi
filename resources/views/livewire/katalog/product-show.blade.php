<div>
    <h1>{{ $product->name }}</h1>

    <div>
        Количество: {{ $quantity }}
    </div>

    <button
        type="button"
        wire:click="decreaseQuantity"
    >
        -
    </button>

    <button
        type="button"
        wire:click="increaseQuantity"
    >
        +
    </button>
</div>
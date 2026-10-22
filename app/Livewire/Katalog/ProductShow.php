<?php

namespace App\Livewire\Katalog;

use App\Models\Product;
use App\Services\CartService;
use Livewire\Component;

class ProductShow extends Component
{
    public Product $product;

    public int $quantity = 1;

    public array $selectedModifiers = [];

    public function mount(Product $product): void
    {
        abort_unless($product->is_active, 404);

        $this->product = $product->load([
            'category',
            'images',
            'productModifiers.modifier',
        ]);

        $this->selectedModifiers = $this->product->productModifiers
            ->filter(fn ($item) => $item->is_required && $item->modifier?->is_active)
            ->pluck('modifier_id')
            ->map(fn ($id) => (int) $id)
            ->all();
    }

    public function increaseQuantity(): void
    {
        $this->quantity = min(99, $this->quantity + 1);
    }

    public function decreaseQuantity(): void
    {
        $this->quantity = max(1, $this->quantity - 1);
    }

    public function addToCart(CartService $cart): void
    {
        $this->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
            'selectedModifiers' => ['array'],
            'selectedModifiers.*' => ['integer'],
        ]);

        try {
            $cart->add($this->product, $this->quantity, $this->selectedModifiers);
        } catch (\InvalidArgumentException $exception) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'selectedModifiers' => $exception->getMessage(),
            ]);
        }

        $this->dispatch('cart-updated');

        session()->flash('cart_message', 'Товар добавлен в корзину.');
    }

    public function render()
    {
        return view('livewire.katalog.product-show')
            ->layout('components.layouts.app', [
                'title' => $this->product->name . ' — ' . config('app.name'),
                'metaDescription' => $this->product->description
                    ?: 'Закажите ' . $this->product->name . ' с доставкой или самовывозом.',
                'metaImage' => $this->product->images->first()
                    ? asset('storage/' . ltrim($this->product->images->first()->path, '/'))
                    : null,
            ]);
    }
}

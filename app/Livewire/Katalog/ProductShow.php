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
        $cart->add(
            $this->product,
            $this->quantity,
            $this->selectedModifiers
        );

        session()->flash(
            'cart_message',
            'Товар добавлен в корзину.'
        );

        $this->redirectRoute('cart');
    }

    public function render()
    {
        return view('livewire.katalog.product-show')
            ->layout('components.layouts.app');
    }
}
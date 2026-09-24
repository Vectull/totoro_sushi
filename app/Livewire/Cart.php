<?php

namespace App\Livewire;

use App\Services\CartService;
use Livewire\Component;

class Cart extends Component
{
    public function updateQuantity(
        CartService $cart,
        string $key,
        int $quantity
    ): void {
        $cart->update($key, $quantity);
    }

    public function remove(
        CartService $cart,
        string $key
    ): void {
        $cart->remove($key);
    }

    public function clear(CartService $cart): void
    {
        $cart->clear();
    }

    public function render(CartService $cart)
    {
        return view('livewire.cart', [
            'items' => $cart->items(),
            'total' => $cart->total(),
            'count' => $cart->count(),
        ])->layout('components.layouts.app');
    }
}
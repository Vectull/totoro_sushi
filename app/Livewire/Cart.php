<?php

namespace App\Livewire;

use App\Services\CartService;
use Livewire\Component;

class Cart extends Component
{
    public int $chopsticks = 0;

    public function mount(CartService $cart): void
    {
        $this->chopsticks = $cart->chopsticks();
    }

    public function decreaseChopsticks(CartService $cart): void
    {
        $this->chopsticks = max(0, $this->chopsticks - 1);
        $cart->setChopsticks($this->chopsticks);
    }

    public function increaseChopsticks(CartService $cart): void
    {
        $this->chopsticks = min(99, $this->chopsticks + 1);
        $cart->setChopsticks($this->chopsticks);
    }

  public function updateQuantity(
    CartService $cart,
    string $key,
    int $quantity
): void {
    $cart->update($key, $quantity);

    $this->dispatch('cart-updated');
}

    public function remove(
    CartService $cart,
    string $key
): void {
    $cart->remove($key);

    $this->dispatch('cart-updated');
}

    public function clear(CartService $cart): void
    {
        $cart->clear();
        $this->dispatch('cart-updated');
    }

    public function render(CartService $cart)
    {
        return view('livewire.cart', [
            'items' => $cart->items(),
            'total' => $cart->total(),
            'count' => $cart->count(),
        ])->layout('components.layouts.app', [
            'title' => 'Корзина — ' . config('app.name'),
            'metaDescription' => 'Проверьте выбранные блюда перед оформлением заказа.',
            'metaRobots' => 'noindex, nofollow',
        ]);
    }
}

<?php

namespace App\Livewire;

use App\Services\CartService;
use Livewire\Attributes\On;
use Livewire\Component;

class SiteHeader extends Component
{
    public int $cartCount = 0;

    public function mount(CartService $cart): void
    {
        $this->cartCount = $cart->count();
    }

    #[On('cart-updated')]
    public function refreshCartCount(CartService $cart): void
    {
        $this->cartCount = $cart->count();
    }

    public function render()
    {
        return view('livewire.site-header');
    }
}
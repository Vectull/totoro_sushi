<?php

namespace App\Livewire;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OrderShow extends Component
{
    public Order $order;

    public function mount(Order $order, ?string $token = null): void
    {
        if ($order->user_id !== null) {
            // Заказ авторизованного пользователя доступен только владельцу.
            if (! Auth::check() || $order->user_id !== Auth::id()) {
                abort(404);
            }
        } else {
            // Гостевой заказ доступен только по секретному токену.
            if (
                ! is_string($order->tracking_token) ||
                ! is_string($token) ||
                ! hash_equals($order->tracking_token, $token)
            ) {
                abort(404);
            }
        }

        $this->order = $order->load('items');
    }

    public function refreshOrder(): void
    {
        $this->order->refresh()->load('items');
    }

    public function render()
    {
        return view('livewire.order-show')
            ->layout('components.layouts.app');
    }
}
<?php

namespace App\Livewire;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OrderShow extends Component
{
    public Order $order;

    public function mount(Order $order): void
    {
        $order->load('items');

        if (
            $order->user_id !== null &&
            $order->user_id !== Auth::id()
        ) {
            abort(404);
        }

        $this->order = $order;
    }

    public function render()
    {
        return view('livewire.order-show')
            ->layout('components.layouts.app');
    }
}
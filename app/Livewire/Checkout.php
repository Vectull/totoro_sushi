<?php

namespace App\Livewire;

use App\Enums\OrderDeliveryMethod;
use App\Enums\OrderPaymentMethod;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Checkout extends Component
{
    public string $customerName = '';
    public string $customerPhone = '';
    public string $customerEmail = '';
    public string $deliveryAddress = '';
    public string $comment = '';

    public string $deliveryMethod = 'courier';
    public string $paymentMethod = 'cash';

    public function mount(CartService $cart): void
    {
        if ($cart->count() === 0) {
            $this->redirectRoute('cart');
            return;
        }

        if (Auth::check()) {
            $this->customerName = Auth::user()->name ?? '';
            $this->customerEmail = Auth::user()->email ?? '';
        }
    }

    public function updatedDeliveryMethod(string $value): void
    {
        $this->resetValidation('deliveryAddress');

        if ($value === 'pickup') {
            $this->deliveryAddress = '';
        }
    }

    public function createOrder(
        OrderService $orders,
        CartService $cart
    ): void {
        $this->validate([
            'customerName' => [
                'required',
                'string',
                'min:2',
                'max:255',
            ],
            'customerPhone' => [
                'required',
                'string',
                'min:6',
                'max:32',
            ],
            'customerEmail' => [
                'nullable',
                'email',
                'max:255',
            ],
            'deliveryMethod' => [
                'required',
                'in:' . implode(',', array_column(
                    OrderDeliveryMethod::cases(),
                    'value'
                )),
            ],
            'paymentMethod' => [
                'required',
                'in:' . implode(',', array_column(
                    OrderPaymentMethod::cases(),
                    'value'
                )),
            ],
            'deliveryAddress' => [
                'required_if:deliveryMethod,courier',
                'nullable',
                'string',
                'min:5',
                'max:1000',
            ],
            'comment' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $order = $orders->create([
            'user_id' => Auth::id(),

            'customer_name' => $this->customerName,
            'customer_phone' => $this->customerPhone,
            'customer_email' => $this->customerEmail ?: null,

            'delivery_method' => $this->deliveryMethod,
            'payment_method' => $this->paymentMethod,

            'delivery_address' => $this->deliveryAddress ?: null,
            'comment' => $this->comment ?: null,

            'delivery_cost' => 0,
            'discount' => 0,
        ]);

        // Запоминаем последний заказ для кнопки отслеживания.
        session([
            'last_order_id' => $order->id,
            'last_order_token' => $order->user_id === null
                ? $order->tracking_token
                : null,
        ]);

        $this->dispatch('cart-updated');

        $this->redirectRoute(
            'order.show',
            array_filter([
                'order' => $order->id,
                'token' => $order->user_id === null
                    ? $order->tracking_token
                    : null,
            ], fn ($value) => $value !== null)
        );
    }

    public function render(CartService $cart)
    {
        return view('livewire.checkout', [
            'items' => $cart->items(),
            'total' => $cart->total(),
            'count' => $cart->count(),
        ])->layout('components.layouts.app');
    }
}

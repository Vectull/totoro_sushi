<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Illuminate\Support\Str;

class OrderService
{
    public function __construct(
        private CartService $cart
    ) {
    }

    public function create(array $customerData): Order
    {
        $items = $this->cart->items();

        if (empty($items)) {
            throw new InvalidArgumentException(
                'Нельзя создать заказ с пустой корзиной.'
            );
        }

        return DB::transaction(function () use ($customerData, $items) {
            $subtotal = 0;

            $order = new Order();

            $order->tracking_token = Str::random(64);
            $order->user_id = $customerData['user_id'] ?? null;
            $order->status = OrderStatus::Preparing;
            $order->payment_status = 'pending';

            $order->customer_name = $customerData['customer_name'];
            $order->customer_phone = $customerData['customer_phone'];
            $order->customer_email = $customerData['customer_email'] ?? null;

            $order->delivery_address = $customerData['delivery_address'];
            $order->comment = $customerData['comment'] ?? null;

            $order->delivery_cost = $customerData['delivery_cost'] ?? 0;
            $order->discount = $customerData['discount'] ?? 0;

            // Сначала сохраняем заказ,
            // чтобы получить его ID для order_items.
            $order->subtotal = 0;
            $order->total = 0;
            $order->save();

            foreach ($items as $item) {
                $product = Product::query()
                    ->find($item['product_id']);

                if (! $product || ! $product->is_active) {
                    throw new InvalidArgumentException(
                        "Товар «{$item['name']}» больше недоступен."
                    );
                }

                $basePrice = (float) $product->price;

                $modifiers = collect($item['modifiers'] ?? [])
                    ->map(function (array $modifier) {
                        return [
                            'id' => (int) $modifier['id'],
                            'name' => $modifier['name'],
                            'price' => (float) $modifier['price'],
                        ];
                    })
                    ->values()
                    ->all();

                $modifierTotal = collect($modifiers)
                    ->sum('price');

                $unitPrice = $basePrice + $modifierTotal;

                $quantity = max(
                    1,
                    min((int) $item['quantity'], 99)
                );

                $itemTotal = $unitPrice * $quantity;

                $order->items()->create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'unit_price' => $unitPrice,
                    'quantity' => $quantity,
                    'total' => $itemTotal,
                    'modifiers' => $modifiers,
                ]);

                $subtotal += $itemTotal;
            }

            $deliveryCost = max(
                0,
                (float) $order->delivery_cost
            );

            $discount = max(
                0,
                (float) $order->discount
            );

            $total = max(
                0,
                $subtotal + $deliveryCost - $discount
            );

            $order->subtotal = $subtotal;
            $order->total = $total;
            $order->save();

            $this->cart->clear();

            return $order->load('items');
        });
    }
}
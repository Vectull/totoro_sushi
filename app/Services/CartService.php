<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Session;
use InvalidArgumentException;

class CartService
{
    private const KEY = 'cart';

    public function items(): array
    {
        return Session::get(self::KEY, []);
    }

    public function add(
        Product $product,
        int $quantity = 1,
        array $modifierIds = []
    ): void {
        if (! $product->is_active) {
            throw new InvalidArgumentException('Товар недоступен.');
        }

        $quantity = max(1, min($quantity, 99));

        $product->loadMissing('productModifiers.modifier');

        $allowedModifiers = $product->productModifiers
            ->filter(
                fn ($item) =>
                    $item->modifier &&
                    $item->modifier->is_active
            )
            ->keyBy('modifier_id');

        $modifierIds = collect($modifierIds)
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->filter(
                fn ($id) =>
                    $allowedModifiers->has($id)
            )
            ->values();

        foreach ($product->productModifiers as $productModifier) {
            if (
                $productModifier->is_required &&
                ! $modifierIds->contains(
                    (int) $productModifier->modifier_id
                )
            ) {
                throw new InvalidArgumentException(
                    "Выберите обязательную добавку: {$productModifier->modifier->name}."
                );
            }
        }

        $modifiers = $modifierIds
            ->map(function (int $id) use ($allowedModifiers) {
                $modifier = $allowedModifiers[$id]->modifier;

                return [
                    'id' => $modifier->id,
                    'name' => $modifier->name,
                    'price' => (float) $modifier->price,
                ];
            })
            ->values()
            ->all();

        $unitPrice = (float) $product->price
            + collect($modifiers)->sum('price');

        $key = $this->lineKey(
            $product->id,
            $modifierIds->all()
        );

        $items = $this->items();

        if (isset($items[$key])) {
            $items[$key]['quantity'] = min(
                99,
                $items[$key]['quantity'] + $quantity
            );
        } else {
            $items[$key] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'image' => $product->images->first()?->path,
                'base_price' => (float) $product->price,
                'modifiers' => $modifiers,
                'unit_price' => $unitPrice,
                'quantity' => $quantity,
            ];
        }

        Session::put(self::KEY, $items);
    }

    public function update(string $key, int $quantity): void
    {
        $items = $this->items();

        if (! isset($items[$key])) {
            return;
        }

        $quantity = max(0, min($quantity, 99));

        if ($quantity === 0) {
            unset($items[$key]);
        } else {
            $items[$key]['quantity'] = $quantity;
        }

        Session::put(self::KEY, $items);
    }

    public function remove(string $key): void
    {
        $items = $this->items();

        unset($items[$key]);

        Session::put(self::KEY, $items);
    }

    public function clear(): void
    {
        Session::forget(self::KEY);
    }

    public function total(): float
    {
        return collect($this->items())
            ->sum(
                fn (array $item) =>
                    $item['unit_price'] * $item['quantity']
            );
    }

    public function count(): int
    {
        return collect($this->items())
            ->sum(
                fn (array $item) =>
                    $item['quantity']
            );
    }

    private function lineKey(
        int $productId,
        array $modifierIds
    ): string {
        sort($modifierIds);

        return $productId . ':' . implode(',', $modifierIds);
    }
}
<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Modifier;
use Illuminate\Support\Facades\Session;
use InvalidArgumentException;

class CartService
{
    private const KEY = 'cart';
    private const CHOPSTICKS_KEY = 'cart_chopsticks';

    public function items(): array
    {
        return Session::get(self::KEY, []);
    }

    public function chopsticks(): int
    {
        return max(0, min((int) Session::get(self::CHOPSTICKS_KEY, 0), 99));
    }

    public function setChopsticks(int $quantity): void
    {
        Session::put(self::CHOPSTICKS_KEY, max(0, min($quantity, 99)));
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
                    $item->modifier->is_active &&
                    $item->modifier->slug !== 'chopsticks'
            )
            ->keyBy('modifier_id');

        if ($allowedModifiers->isEmpty()) {
            $allowedModifiers = Modifier::query()
                ->where('is_active', true)
                ->where('slug', '!=', 'chopsticks')
                ->get()
                ->keyBy('id')
                ->map(fn (Modifier $modifier) => (object) [
                    'modifier' => $modifier,
                ]);
        }

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
                $productModifier->modifier?->is_active &&
                ! $modifierIds->contains(
                    (int) $productModifier->modifier_id
                )
            ) {
                $modifierName = $productModifier->modifier?->name ?? 'обязательная добавка';

                throw new InvalidArgumentException(
                    "Выберите обязательную добавку: {$modifierName}."
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

        if ($items === []) {
            Session::forget(self::CHOPSTICKS_KEY);
        }
    }

    public function remove(string $key): void
    {
        $items = $this->items();

        unset($items[$key]);

        Session::put(self::KEY, $items);

        if ($items === []) {
            Session::forget(self::CHOPSTICKS_KEY);
        }
    }

    public function clear(): void
    {
        Session::forget(self::KEY);
        Session::forget(self::CHOPSTICKS_KEY);
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

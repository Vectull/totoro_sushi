<?php

namespace App\Livewire\Katalog;

use App\Models\Category;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use Livewire\Component;
use Livewire\WithPagination;

class ProductCatalog extends Component
{
    use WithPagination;

    public ?int $categoryId = null;
    public ?int $selectedProductId = null;
    public int $quantity = 1;
    public array $selectedModifiers = [];
    public int $bannerIndex = 0;

    public function nextBanner(): void
    {
        $this->bannerIndex++;
    }

    public function previousBanner(): void
    {
        $this->bannerIndex--;
    }

    public function selectCategory(?int $categoryId): void
    {
        $this->categoryId = $categoryId;
        $this->resetPage();
        $this->closeProduct();
    }

    public function openProduct(int $productId): void
    {
        $product = Product::query()
            ->where('is_active', true)
            ->with('productModifiers.modifier')
            ->findOrFail($productId);

        $this->selectedProductId = $product->id;
        $this->quantity = 1;
        $this->selectedModifiers = [];

        // Автоматически выбираем обязательные добавки.
        foreach ($product->productModifiers as $item) {
            if (
                $item->is_required &&
                $item->modifier &&
                $item->modifier->is_active
            ) {
                $this->selectedModifiers[] = $item->modifier_id;
            }
        }
    }

    public function closeProduct(): void
    {
        $this->selectedProductId = null;
        $this->quantity = 1;
        $this->selectedModifiers = [];
    }

    public function decreaseQuantity(): void
    {
        $this->quantity = max(1, $this->quantity - 1);
    }

    public function increaseQuantity(): void
    {
        $this->quantity = min(99, $this->quantity + 1);
    }

    public function addToCart(CartService $cart): void
    {
        $product = Product::query()
            ->where('is_active', true)
            ->with(['images', 'productModifiers.modifier'])
            ->findOrFail($this->selectedProductId);

        $this->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
            'selectedModifiers' => ['array'],
            'selectedModifiers.*' => ['integer'],
        ]);

        try {
            $cart->add(
                $product,
                $this->quantity,
                $this->selectedModifiers
            );
        } catch (InvalidArgumentException $exception) {
            throw ValidationException::withMessages([
                'selectedModifiers' => $exception->getMessage(),
            ]);
        }

        $this->dispatch('cart-updated');

        $this->closeProduct();

        session()->flash('cart-message', 'Товар добавлен в корзину.');
    }

    public function render()
    {
        $categories = Category::query()
            ->where('is_active', true)
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        $products = Product::query()
            ->where('is_active', true)
            ->when(
                $this->categoryId !== null,
                fn ($query) => $query->where(
                    'category_id',
                    $this->categoryId
                )
            )
            ->with(['category', 'images'])
            ->latest()
            ->paginate(12);

        $promotions = Product::query()
            ->where('is_active', true)
            ->where('is_promotion', true)
            ->with(['images', 'category'])
            ->latest()
            ->get();

        $bannerIndex = $promotions->isEmpty()
            ? 0
            : (($this->bannerIndex % $promotions->count()) + $promotions->count()) % $promotions->count();

        $selectedProduct = $this->selectedProductId
            ? Product::query()
                ->where('is_active', true)
                ->with([
                    'category',
                    'images',
                    'productModifiers.modifier',
                ])
                ->find($this->selectedProductId)
            : null;

        return view('livewire.katalog.product-catalog', [
            'categories' => $categories,
            'products' => $products,
            'promotions' => $promotions,
            'bannerIndex' => $bannerIndex,
            'selectedProduct' => $selectedProduct,
        ])->layout('components.layouts.app', [
            'title' => 'Каталог суши и роллов — ' . config('app.name'),
            'metaDescription' => 'Суши, роллы и сеты в меню ' . config('app.name') . '. Выберите блюда и оформите заказ с доставкой или самовывозом.',
        ]);
    }
}

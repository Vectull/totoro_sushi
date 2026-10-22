<?php

namespace App\Livewire\Katalog;

use App\Models\Category;
use App\Models\Modifier;
use App\Models\Product;
use App\Models\ProductModifier;
use App\Models\PromotionBanner;
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
        $count = $this->carouselItemCount();
        if ($count < 2) {
            $this->bannerIndex = 0;

            return;
        }

        $currentIndex = (($this->bannerIndex % $count) + $count) % $count;
        $this->bannerIndex = ($currentIndex + 1) % $count;
    }

    public function previousBanner(): void
    {
        $count = $this->carouselItemCount();
        if ($count < 2) {
            $this->bannerIndex = 0;

            return;
        }

        $currentIndex = (($this->bannerIndex % $count) + $count) % $count;
        $this->bannerIndex = ($currentIndex - 1 + $count) % $count;
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
        $this->dispatch('product-modal-opened');

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
        $this->dispatch('product-modal-closed');
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

    private function carouselItemCount(): int
    {
        $bannerCount = PromotionBanner::query()->active()->count();

        return $bannerCount > 0
            ? $bannerCount
            : Product::query()
                ->where('is_active', true)
                ->where('is_promotion', true)
                ->count();
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

        $banners = PromotionBanner::query()
            ->active()
            ->get();

        if ($banners->isEmpty()) {
            $banners = Product::query()
                ->where('is_active', true)
                ->where('is_promotion', true)
                ->with('images')
                ->latest()
                ->get()
                ->map(fn (Product $product) => (object) [
                    'id' => $product->id,
                    'title' => $product->name,
                    'description' => $product->description,
                    'image_path' => $product->images->first()?->path,
                    'button_label' => 'Смотреть товар',
                    'button_url' => route('catalog.product', ['product' => $product->slug]),
                ]);
        }

        $bannerIndex = $banners->isEmpty()
            ? 0
            : (($this->bannerIndex % $banners->count()) + $banners->count()) % $banners->count();

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

        if ($selectedProduct && $selectedProduct->productModifiers->isEmpty()) {
            $defaultModifiers = Modifier::query()
                ->where('is_active', true)
                ->where('slug', '!=', 'chopsticks')
                ->orderBy('id')
                ->get()
                ->map(function (Modifier $modifier) {
                    $productModifier = new ProductModifier([
                        'modifier_id' => $modifier->id,
                        'is_required' => false,
                    ]);
                    $productModifier->setRelation('modifier', $modifier);

                    return $productModifier;
                });

            $selectedProduct->setRelation('productModifiers', $defaultModifiers);
        }

        return view('livewire.katalog.product-catalog', [
            'categories' => $categories,
            'products' => $products,
            'banners' => $banners,
            'bannerIndex' => $bannerIndex,
            'selectedProduct' => $selectedProduct,
        ])->layout('components.layouts.app', [
            'title' => 'Каталог суши и роллов — ' . config('app.name'),
            'metaDescription' => 'Суши, роллы и сеты в меню ' . config('app.name') . '. Выберите блюда и оформите заказ с доставкой или самовывозом.',
        ]);
    }
}

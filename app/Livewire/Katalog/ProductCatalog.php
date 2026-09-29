<?php

namespace App\Livewire\Katalog;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductCatalog extends Component
{
    use WithPagination;

    public ?int $categoryId = null;

    public function selectCategory(?int $categoryId): void
    {
        $this->categoryId = $categoryId;

        $this->resetPage();
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

        return view('livewire.katalog.product-catalog', [
            'categories' => $categories,
            'products' => $products,
        ]);
    }
}
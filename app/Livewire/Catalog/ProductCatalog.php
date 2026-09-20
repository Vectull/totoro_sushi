<?php

namespace App\Livewire\Catalog;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductCatalog extends Component
{
    use WithPagination;

    public ?int $selectedCategory = null;

    public function selectCategory(?int $categoryId): void
    {
        $this->selectedCategory = $categoryId;
        $this->resetPage();
    }

    public function render()
    {
        $categories = Category::query()
            ->where('is_active', true)
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $products = Product::query()
            ->where('is_active', true)
            ->with(['category', 'images'])
            ->when(
                $this->selectedCategory,
                fn ($query) => $query->where('category_id', $this->selectedCategory)
            )
            ->latest()
            ->paginate(12);

        return view('livewire.catalog.product-catalog', [
            'categories' => $categories,
            'products' => $products,
        ])->layout('components.layouts.app');
    }
}
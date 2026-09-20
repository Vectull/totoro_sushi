<?php

namespace App\Livewire\Catalog;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductCatalog extends Component
{
    use WithPagination;

    public function render()
    {
        $products = Product::query()
            ->where('is_active', true)
            ->with(['category', 'images'])
            ->latest()
            ->paginate(12);

        return view('livewire.catalog.product-catalog', [
            'products' => $products,
        ]);
    }
}
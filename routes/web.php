<?php

use App\Livewire\Cart;
use App\Livewire\Home;
use App\Livewire\Katalog\ProductCatalog;
use App\Livewire\Katalog\ProductShow;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)
    ->name('home');

Route::get('/catalog', ProductCatalog::class)
    ->name('catalog');

Route::get('/catalog/{product:slug}', ProductShow::class)
    ->name('catalog.product');

Route::get('/cart', Cart::class)
    ->name('cart');
<?php

use App\Livewire\Cart;
use App\Livewire\Home;
use App\Livewire\Katalog\ProductCatalog;
use App\Livewire\Katalog\ProductShow;
use App\Livewire\OrderShow;
use App\Livewire\Checkout;
use Illuminate\Support\Facades\Route;
use App\Livewire\Contacts;

Route::get('/', Home::class)
    ->name('home');

Route::get('/contacts', Contacts::class)
    ->name('contacts');

Route::get('/catalog', ProductCatalog::class)
    ->name('catalog');

Route::get('/catalog/{product:slug}', ProductShow::class)
    ->name('catalog.product');

Route::get('/cart', Cart::class)
    ->name('cart');

Route::get('/checkout', Checkout::class)
    ->name('checkout');

Route::get('/orders/{order}/{token?}', OrderShow::class)
->name('order.show');
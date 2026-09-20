<?php

use App\Livewire\Home;
use App\Livewire\Catalog\ProductCatalog;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)
    ->name('home');

Route::get('/catalog', ProductCatalog::class)
    ->name('catalog');
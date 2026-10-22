<?php

use App\Livewire\Cart;
use App\Livewire\Home;
use App\Livewire\Katalog\ProductCatalog;
use App\Livewire\Katalog\ProductShow;
use App\Livewire\OrderShow;
use App\Livewire\Checkout;
use Illuminate\Support\Facades\Route;
use App\Livewire\Contacts;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PhoneAuthenticationController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VKontakteAuthenticationController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('throttle:login')
        ->name('login.store');

    Route::get('/register', [RegisteredUserController::class, 'create'])
        ->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])
        ->name('register.store');

    Route::get('/auth/phone', [PhoneAuthenticationController::class, 'showPhoneForm'])
        ->name('phone-auth.form');

    Route::post('/register/phone/send-code', [PhoneAuthenticationController::class, 'sendCode'])
        ->middleware('throttle:phone-auth-send')
        ->name('phone-auth.send');
    Route::get('/register/phone/verify', [PhoneAuthenticationController::class, 'showVerification'])
        ->name('phone-auth.verify.form');
    Route::post('/register/phone/verify', [PhoneAuthenticationController::class, 'verifyCode'])
        ->middleware('throttle:phone-auth-verify')
        ->name('phone-auth.verify');

    Route::get('/auth/vk/redirect', [VKontakteAuthenticationController::class, 'redirect'])
        ->name('auth.vk.redirect');
    Route::get('/auth/vk/callback', [VKontakteAuthenticationController::class, 'callback'])
        ->name('auth.vk.callback');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

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

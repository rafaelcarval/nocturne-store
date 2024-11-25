<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ThriftStoreController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Auth;

Auth::routes();
// Página inicial
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rotas da loja
Route::get('/store', [StoreController::class, 'index'])->name('store.index');
Route::get('/store/{product}', [StoreController::class, 'show'])->name('store.show');
Route::get('/thrift_store', [ThriftStoreController::class, 'index'])->name('thrift_store.index');
Route::get('/thrift_store/{product}', [StoreController::class, 'show'])->name('thrift_store.show');

//images
Route::get('/images/{filename}', function ($filename) {
    $path = resource_path('images/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
})->name('images');

// Cadastro de clientes
Route::get('/clients/create', [AuthController::class, 'createClient'])->name('clients.create');
Route::post('/clients', [AuthController::class, 'storeClient'])->name('clients.store');

// Login e logout
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Página de política de privacidade (pública)
Route::get('/privacy/cookies', function () {
    return view('privacy.cookies');
})->name('privacy.cookies');

// Carrinho
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/update-size/{id}', [CartController::class, 'updateSize'])->name('cart.update-size');
Route::post('/cart/applyCoupon', [CartController::class, 'applyCoupon'])->name('cart.applyCoupon');
Route::post('/cart/calculate-freight', [CartController::class, 'calculateFreight'])->name('calculate.freight');
Route::get('/cart/removeCoupon', [CartController::class, 'removeCoupon'])->name('cart.removeCoupon');
//Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/address', [CheckoutController::class, 'saveAddress'])->name('checkout.saveAddress');

//Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
//Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

use Illuminate\Support\Facades\Log;

Route::get('/test-log', function () {
    //Log::debug('Este é um teste de log.');
    //return 'Log registrado.';
    return csrf_token();
});

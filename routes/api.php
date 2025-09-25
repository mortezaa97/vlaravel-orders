<?php

declare(strict_types=1);

use Mortezaa97\Orders\Http\Controllers\Cart\MergeCartController;
use Mortezaa97\Orders\Http\Controllers\Cart\PayCartController;
use Mortezaa97\Orders\Http\Controllers\CartController;
use Mortezaa97\Orders\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {
    Route::get('carts', [CartController::class, 'index'])->middleware('auth:api')->name('carts.index');
    Route::get('carts/{cart}', [CartController::class, 'show'])->name('carts.show');
    Route::post('carts', [CartController::class, 'store'])->name('carts.store');
    Route::post('merge-carts/{cart:storage_id}', MergeCartController::class)->middleware('auth:api')->name('carts.merge');
    Route::match(['put', 'patch'], 'carts/{cart}', [CartController::class, 'update'])->name('carts.update');
    Route::delete('carts/{cart}', [CartController::class, 'destroy'])->name('carts.destroy');
    Route::post('pay/carts/{cart}', PayCartController::class)->middleware('auth:api')->name('carts.pay');

    Route::get('orders', [OrderController::class, 'index'])->middleware('auth:api')->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});


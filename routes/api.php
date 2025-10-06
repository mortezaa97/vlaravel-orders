<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Mortezaa97\Orders\Http\Controllers\Cart\MergeCartController;
use Mortezaa97\Orders\Http\Controllers\Cart\PayCartController;
use Mortezaa97\Orders\Http\Controllers\CartController;
use Mortezaa97\Orders\Http\Controllers\OrderController;
use Mortezaa97\Orders\Http\Controllers\PayTypeController;
use Mortezaa97\Orders\Http\Controllers\SendTypeController;

Route::prefix('api')->middleware('api')->group(function () {
    Route::get('carts', [CartController::class, 'index'])->middleware('auth:api')->name('carts.index');
    Route::get('carts/{cart:storage_id}', [CartController::class, 'show'])->name('carts.show');
    Route::post('carts', [CartController::class, 'store'])->middleware('auth:api')->name('carts.store');
    Route::post('merge-carts/{cart:storage_id}', MergeCartController::class)->middleware('auth:api')->name('carts.merge');
    Route::match(['put', 'patch'], 'carts/{cart:storage_id}', [CartController::class, 'update'])->name('carts.update');
    Route::delete('carts/{cart:storage_id}', [CartController::class, 'destroy'])->name('carts.destroy');
    Route::post('pay/carts/{cart:storage_id}', PayCartController::class)->middleware('auth:api')->name('carts.pay');

    Route::get('orders', [OrderController::class, 'index'])->middleware('auth:api')->name('orders.index');
    Route::get('orders/{order:code}', [OrderController::class, 'show'])->name('orders.show');

    Route::get('send/types', [SendTypeController::class, 'index'])->name('sendTypes.index');
    Route::get('send/types/{sendType}', [SendTypeController::class, 'show'])->name('sendTypes.show');

    Route::get('pay/types', [PayTypeController::class, 'index'])->name('payTypes.index');
    Route::get('pay/types/{payType}', [PayTypeController::class, 'show'])->name('payTypes.show');
});

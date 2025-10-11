<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Mortezaa97\Orders\Http\Controllers\OrderController;

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('orders/{order:code}/print', [OrderController::class, 'print'])
        ->name('orders.print');
});

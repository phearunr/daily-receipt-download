<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Stores\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware([
    'auth:sanctum',
])->prefix('stores')
    ->name('stores.')
    ->group(function () {
        Route::controller(OrderController::class)->group(function ($router) {
            $router->get('/orders', 'index')->name('orders.index');
            $router->get('/orders/{order_id}/download', 'download')->name('orders.download');
        });
    });

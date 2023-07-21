<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BasketController;

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
])->prefix('baskets')
    ->name('baskets.')
    ->group(function () {
        Route::controller(BasketController::class)->group(function ($router) {
            $router->get('/users', 'index')->name('users.index');
            $router->post('/users', 'store')->name('users.store');
            $router->put('/users/{id}/comfirm', 'confirm')->name('users.confirm');
            $router->put('/users/{order_drop_id}/confirm-barcode', 'confirmBarcodeIncreaseDropQuantity')->name('users.confirm.barcode');
        });
    });

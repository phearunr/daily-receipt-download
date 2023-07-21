<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DriverDashboardController;
use App\Http\Controllers\Drivers\HistoryController;

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
    'is_driverman'
])->prefix('drivers')
    ->name('drivers.')
    ->group(function () {
        Route::controller(DriverDashboardController::class)->group(function ($router) {
            $router->get('/dashboard', 'index')->name('dashboard.index');
        });

        Route::controller(HistoryController::class)->group(function ($router) {
            $router->get('/history', 'index')->name('history.index');
        });
    });

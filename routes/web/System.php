<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\System\UserController;
use App\Http\Controllers\System\NotificationController;

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
])->prefix('system')
    ->name('system.')
    ->group(function () {
        Route::controller(NotificationController::class)->group(function ($router) {
            $router->get('/notifications', 'index')->name('notifications.index');
        });
        Route::controller(UserController::class)->group(function ($router) {
            $router->get('/users', 'index')->name('users.index');
            $router->get('/users/create', 'create')->name('users.create');
            $router->post('/users', 'store')->name('users.store');
            $router->get('/users/{user}', 'show')->name('users.show');
            $router->get('/users/{user}/edit', 'edit')->name('users.edit');
            $router->put('/users/{user}', 'update')->name('users.update');
            $router->delete('/users', 'destroy')->name('users.destroy');
        });
    });

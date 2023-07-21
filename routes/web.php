<?php

use Inertia\Inertia;
use App\Mail\OrderShipped;
use App\Models\OD_cn\Order;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/orders', function () {


    Mail::to('phearun.reth.info@gmail.com')->send(new OrderShipped(
        [
            'title' => 'Mail from Webappfix',
            'body' => 'This is for testing email usign smtp',
        ]
    ));

    dd('Email send successfully.');
    // \App\Models\Order::create([
    //     'created_at' => now()
    // ]);
});


Route::get('/', function () {
    return redirect()->route('login');
});

require __DIR__ . '/web/Stores.php';
require __DIR__ . '/web/Drivers.php';
require __DIR__ . '/web/System.php';
require __DIR__ . '/web/Basket.php';
require __DIR__ . '/web/Dashboard.php';

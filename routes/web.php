<?php

use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\customer\FrontendController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/* Auth Routes */
Route::group(['middleware' => 'guest_user'], function () {
    Route::get('/login', [LoginController::class, "index"])->middleware('guest_user')->name('login');
    Route::get('/register', [RegisterController::class, "index"])->middleware('guest_user')->name('register');
    Route::post('/register', [RegisterController::class, "register"])->name('customer.register');
    Route::post('/login', [LoginController::class, "login"])->name('customer.login');
});
Route::post('/logout', [LogoutController::class, 'logout'])->middleware('auth')->name('logout');

/* Customer Routes */
Route::group(['middleware' => 'customer'], function () {
    Route::get('/', [FrontendController::class, "index"])->middleware('customer')->name('customer.home');
});

/* Admin Routes */
Route::group(['middleware' => ['admin', 'auth']], function () {
    Route::get('/admin/dashboard', [DashboardController::class, "index"])->middleware('admin')->name('admin.dashboard');
});

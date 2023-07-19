<?php

use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\customer\AppointmentController;
use App\Http\Controllers\customer\CustomerController;
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
Route::get('/', [FrontendController::class, "index"])->name('customer.home');
Route::group(['middleware' => ['customer', 'auth']], function () {
    Route::get('/customer/appointment', [AppointmentController::class, 'create'])->middleware('customer')->name('customer.appointment');
    Route::post('/customer/appointment/create', [AppointmentController::class, 'store'])->middleware('customer')->name('customer.appointment.create');
});

/* Admin Routes */
Route::group(['middleware' => ['admin', 'auth']], function () {
    Route::get('/admin/dashboard', [DashboardController::class, "index"])->middleware('admin')->name('admin.dashboard');
    Route::get('/customer/all', [CustomerController::class, 'index'])->middleware('admin')->name('customer.all');
    Route::get('/customer/{id}/edit', [CustomerController::class, 'edit'])->middleware('admin')->name('customer.edit');
    Route::post('/customer/{id}/edit', [CustomerController::class, 'update'])->middleware('admin')->name('customer.update');
    Route::get('/customer/{id}/delete', [CustomerController::class, 'destroy'])->middleware('admin')->name('customer.delete');
});

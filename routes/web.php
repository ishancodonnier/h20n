<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DriverController;
use Illuminate\Support\Facades\Route;

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

Route::get('login', [LoginController::class, 'showLoginForm'])->name('showlogin');
Route::post('login', [LoginController::class, 'login'])->name('login');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
    //Users
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user/{id}/update', [UserController::class, 'update'])->name('user.update');
    Route::get('/user/{id}/delete', [UserController::class, 'destroy'])->name('user.destroy');

    //Driver
    Route::get('/driver', [DriverController::class, 'index'])->name('driver.index');
    Route::get('/driver/create', [DriverController::class, 'create'])->name('driver.create');
    Route::post('/driver', [DriverController::class, 'store'])->name('driver.store');
    Route::get('/driver/{id}/edit', [DriverController::class, 'edit'])->name('driver.edit');
    Route::post('/driver/{id}/update', [DriverController::class, 'update'])->name('driver.update');
    Route::get('/driver/{id}/delete', [DriverController::class, 'destroy'])->name('driver.destroy');

    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
});

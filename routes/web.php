<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\DeliveryAreaController;
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
    Route::get('/user/{id}/status', [UserController::class, 'status'])->name('user.status');

    Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/category/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('/category/{id}/update', [CategoryController::class, 'update'])->name('category.update');
    Route::get('/category/{id}/delete', [CategoryController::class, 'destroy'])->name('category.destroy');

    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::post('/product/{id}/update', [ProductController::class, 'update'])->name('product.update');
    Route::get('/product/{id}/delete', [ProductController::class, 'destroy'])->name('product.destroy');
    Route::get('/product/{id}/popular', [ProductController::class, 'popular'])->name('product.popular');
    Route::post('/product/delete-image-resource/{product_id}/{product_resource_id}', [ProductController::class, 'delete_image_from_resource'])->name('product.delete.image.resource');

    //Driver
    Route::get('/driver', [DriverController::class, 'index'])->name('driver.index');
    Route::get('/driver/create', [DriverController::class, 'create'])->name('driver.create');
    Route::post('/driver', [DriverController::class, 'store'])->name('driver.store');
    Route::get('/driver/{id}/edit', [DriverController::class, 'edit'])->name('driver.edit');
    Route::post('/driver/{id}/update', [DriverController::class, 'update'])->name('driver.update');
    Route::get('/driver/{id}/delete', [DriverController::class, 'destroy'])->name('driver.destroy');

    //Warehouse
    Route::get('/warehouse', [WarehouseController::class, 'index'])->name('warehouse.index');
    Route::get('/warehouse/create', [WarehouseController::class, 'create'])->name('warehouse.create');
    Route::post('/warehouse', [WarehouseController::class, 'store'])->name('warehouse.store');
    Route::get('/warehouse/{id}/edit', [WarehouseController::class, 'edit'])->name('warehouse.edit');
    Route::post('/warehouse/{id}/update', [WarehouseController::class, 'update'])->name('warehouse.update');
    Route::get('/warehouse/{id}/delete', [WarehouseController::class, 'destroy'])->name('warehouse.destroy');

    //Delivery Area
    Route::get('/delivery-area', [DeliveryAreaController::class, 'index'])->name('delivery.area.index');
    Route::get('/delivery-area/create', [DeliveryAreaController::class, 'create'])->name('delivery.area.create');
    Route::post('/delivery-area', [DeliveryAreaController::class, 'store'])->name('delivery.area.store');
    Route::get('/delivery-area/{id}/edit', [DeliveryAreaController::class, 'edit'])->name('delivery.area.edit');
    Route::post('/delivery-area/{id}/update', [DeliveryAreaController::class, 'update'])->name('delivery.area.update');
    Route::get('/delivery-area/{id}/delete', [DeliveryAreaController::class, 'destroy'])->name('delivery.area.destroy');

    //Address
    Route::get('/user-address', [AddressController::class, 'index'])->name('address.index');
    Route::get('/user-address/data', [AddressController::class, 'data'])->name('address.index.data');
    Route::post('/address/warehouse/edit', [AddressController::class, 'warehouse_edit'])->name('address.warehouse.edit');
    Route::post('/address/warehouse/update', [AddressController::class, 'warehouse_update'])->name('address.warehouse.update');

    //Order
    Route::get('/order', [OrderController::class, 'index'])->name('order.index');
    Route::get('/order/data', [OrderController::class, 'data'])->name('order.index.data');

    Route::post('/order/contact/edit', [OrderController::class, 'contact_edit'])->name('order.contact.edit');
    Route::post('/order/contact/update', [OrderController::class, 'contact_update'])->name('order.contact.update');
    Route::post('/order/assign/driver', [OrderController::class, 'driver_assign'])->name('store.assign.to.driver');

    Route::get('/order/create', [OrderController::class, 'create'])->name('order.create');
    Route::get('/order/{id}/edit', [OrderController::class, 'edit'])->name('order.edit');
    Route::get('/order/{id}/delete', [OrderController::class, 'destroy'])->name('order.destroy');

    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
});

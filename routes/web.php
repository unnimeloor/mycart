<?php

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth'], 'prefix' => 'admin'], function () {
    Route::get('/product', [App\Http\Controllers\Admin\ProductController::class, 'list'])->name('admin.product-list');
    Route::get('/product/add', [App\Http\Controllers\Admin\ProductController::class, 'create'])->name('admin.product-create');
    Route::post('/product/save', [App\Http\Controllers\Admin\ProductController::class, 'save'])->name('admin.product-save');
    Route::get('/product/edit/{id}', [App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('admin.product-edit');
    Route::post('/product/update', [App\Http\Controllers\Admin\ProductController::class, 'update'])->name('admin.product-update');
    Route::get('/product/delete/{id}', [App\Http\Controllers\Admin\ProductController::class, 'delete'])->name('admin.product-delete');
});

Auth::routes();

Route::get('/', [App\Http\Controllers\Frontend\ProductController::class, 'productList'])->name('home');
Route::get('/products', [App\Http\Controllers\Frontend\ProductController::class, 'productList'])->name('product.search');

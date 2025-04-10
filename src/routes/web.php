<?php

use App\Http\Controllers\ProductController;
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

// トップページへのアクセスを商品一覧にリダイレクト
Route::get('/', function () {
    return redirect('/products');
});

// 商品一覧ルート
Route::get('/products', [ProductController::class, 'products'])->name('products');

// 商品登録ルート
Route::get('/products/register', [ProductController::class, 'create'])->name('products.create');
Route::post('/products/register', [ProductController::class, 'store'])->name('products.store');

// 商品検索ルート
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');

// 商品詳細ルート
Route::get('/products/{productId}', [ProductController::class, 'show'])->name('products.show');

// 商品更新ルート
Route::get('/products/{productId}/update', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{productId}/update', [ProductController::class, 'update'])->name('products.update');

// 商品削除ルート
Route::delete('/products/{productId}/delete', [ProductController::class, 'destroy'])->name('products.destroy');
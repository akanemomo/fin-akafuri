<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;

// トップページ（商品一覧）
Route::get('/', [ItemController::class, 'index'])->name('items.index');

// 商品詳細ページ
Route::get('/item/{item}', [ItemController::class, 'show'])->name('items.show');

Route::post('/item/{item}/like', [LikeController::class, 'store'])->name('items.like');

Route::delete('/item/{item}/like', [LikeController::class, 'destroy'])->name('items.unlike');

Route::post('/item/{item}/comment', [CommentController::class, 'store'])->name('comments.store');

// 住所変更画面（GET）
Route::get('/item/{item}/address', [ItemController::class, 'editAddress'])->name('items.editAddress');

// 住所変更処理（POST）
Route::post('/item/{item}/address', [ItemController::class, 'updateAddress'])->name('items.updateAddress');

// 商品購入処理（POST）
Route::post('/item/{item}/buy', [ItemController::class, 'buy'])->name('items.buy');

// 商品出品ページ
Route::get('/sell', [ItemController::class, 'create'])->name('items.create');

// 商品出品処理
Route::post('/items', [ItemController::class, 'store'])->name('items.store');

// 購入手続きページ
Route::get('/item/{item}/purchase', [ItemController::class, 'purchase'])->name('items.purchase');
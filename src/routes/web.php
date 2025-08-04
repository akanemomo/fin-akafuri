<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;

// トップページ（商品一覧）
Route::get('/', [ItemController::class, 'index'])->name('items.index');

// 商品詳細ページ
Route::get('/items/{item}', [ItemController::class, 'show'])->name('items.show');

// いいね登録／解除
Route::post('/items/{item}/like', [LikeController::class, 'store'])->name('items.like');
Route::delete('/items/{item}/like', [LikeController::class, 'destroy'])->name('items.unlike');

// コメント投稿
Route::post('/items/{item}/comment', [CommentController::class, 'store'])->name('comments.store');

// 住所変更画面（表示）
Route::get('/items/{item}/address', [ItemController::class, 'editAddress'])->name('items.editAddress');

// 住所変更の処理
Route::post('/items/{item}/address', [UserController::class, 'updateAddress'])
    ->middleware('auth')
    ->name('address.update');

// 商品購入（画面表示＆処理）
Route::get('/items/{item}/purchase', [ItemController::class, 'purchase'])->name('items.purchase');
Route::post('/items/{item}/buy', [ItemController::class, 'buy'])->name('items.buy');

// 商品出品ページ
Route::get('/sell', [ItemController::class, 'create'])->name('items.create');

// 商品出品処理
Route::post('/items', [ItemController::class, 'store'])->name('items.store');

// プロフィール画面
Route::get('/mypage', [UserController::class, 'mypage'])->name('mypage');

// プロフィール編集画面
Route::get('/mypage/profile', [UserController::class, 'edit'])->name('mypage.edit');

// プロフィール更新処理
Route::post('/mypage/profile', [UserController::class, 'update'])->name('mypage.update');

// 商品編集画面を表示
Route::get('/items/{item}/edit', [ItemController::class, 'edit'])->name('items.edit');

// 商品更新処理
Route::put('/items/{item}', [ItemController::class, 'update'])->name('items.update');

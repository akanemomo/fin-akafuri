<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;

// トップページ（商品一覧）
Route::get('/', [ItemController::class, 'index'])->name('items.index');

// 商品詳細ページ
Route::get('/item/{item}', [ItemController::class, 'show'])->name('items.show');

// いいね登録／解除
Route::post('/item/{item}/like', [LikeController::class, 'store'])->name('items.like');
Route::delete('/item/{item}/like', [LikeController::class, 'destroy'])->name('items.unlike');

// コメント投稿
Route::post('/item/{item}/comment', [CommentController::class, 'store'])->name('comments.store');

// 住所変更画面・処理
Route::get('/item/{item}/address', [ItemController::class, 'editAddress'])->name('items.editAddress');
Route::post('/item/{item}/address', [ItemController::class, 'updateAddress'])->name('items.updateAddress');

// 商品購入（画面表示＆処理）
Route::get('/item/{item}/purchase', [ItemController::class, 'purchase'])->name('items.purchase');
Route::post('/item/{item}/buy', [ItemController::class, 'buy'])->name('items.buy');

// 商品出品ページ
Route::get('/sell', [ItemController::class, 'create'])->name('items.create');

// 商品出品処理
Route::post('/items', [ItemController::class, 'store'])->name('items.store');

// プロフィール画面
Route::get('/mypage', [UserController::class, 'mypage'])->name('mypage');

// プロフィール編集画面（初回ログイン時 or 編集ボタン用）
Route::get('/profile/edit', [UserController::class, 'edit'])->name('profile.edit');
@extends('layouts.app')

@php
    use Illuminate\Support\Str;
@endphp

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
<div class="item-detail__wrapper">
    <!-- 左：画像 -->
    <div class="item-detail__image-box">
        @if ($item->image_path)
            @if (Str::startsWith($item->image_path, 'http'))
                <img src="{{ $item->image_path }}" alt="商品画像" class="item-detail__image">
            @else
                <img src="{{ asset('storage/' . $item->image_path) }}" alt="商品画像" class="item-detail__image">
            @endif
        @else
            <span class="image-label">商品画像なし</span>
        @endif
    </div>

    <!-- 右：情報 -->
    <div class="item-detail__info-box">
        <h2 class="item-detail__name">{{ $item->name }}</h2>
        <p class="item-detail__brand">{{ optional($item)->brand }}</p>
        <p class="item-detail__price">¥{{ number_format($item->price) }} <span class="tax-included">（税込）</span></p>

        <!-- いいね・コメント数表示 -->
        <div class="item-detail__icons">
            <span>⭐︎ {{ $likesCount }}</span>
            <span>💬 {{ $commentsCount }}</span>
        </div>

        <!-- いいねボタン -->
        @auth
        <div class="like-button">
            @if ($item->isLikedBy(auth()->user()))
            <!-- いいね済み → DELETEで解除 -->
            <form action="{{ route('items.unlike', $item->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="like-btn">★ いいね済み</button>
            </form>
        @else
            <!-- 未いいね → POSTで登録 -->
            <form action="{{ route('items.like', $item->id) }}" method="POST">
                @csrf
                <button type="submit" class="like-btn">⭐︎ いいね</button>
            </form>
        @endif
    </div>
    @endauth

        <!-- コメント投稿フォーム -->
        @auth
        <div class="comment-form">
            <form action="{{ route('comments.store', $item->id) }}" method="POST">
                @csrf
                <textarea name="content" rows="3" required></textarea>
                <button type="submit">コメントを送信</button>
            </form>
        </div>
        @endauth

        <!-- コメント一覧 -->
        <div class="comment-list">
            <h4>コメント一覧</h4>
            @foreach ($item->comments as $comment)
                <p>{{ $comment->user->name }}：{{ $comment->content }}</p>
            @endforeach
        </div>

        <!-- 購入ボタン -->
        <form action="{{ route('items.purchase', $item->id) }}" method="GET">
            <button type="submit" class="button-red">購入手続きへ</button>
        </form>

        <!-- 商品の情報 -->
        <div class="item-detail__section">
            <h3>商品の情報</h3>
            <p>
                <strong>カテゴリ：</strong>
                @if ($item->category)
                    <span class="badge">{{ $item->category->name }}</span>
                @else
                    <span class="badge">未設定</span>
                @endif
            </p>
            <p><strong>商品の状態：</strong>
                @if ($item->condition === 1)
                    良好
                @elseif ($item->condition === 2)
                    目立った傷や汚れなし
                @elseif ($item->condition === 3)
                    やや傷や汚れあり
                @elseif ($item->condition === 4)
                    状態が悪い
                @else
                    未設定
                @endif
            </p>
        </div>
    </div>
</div>
@endsection
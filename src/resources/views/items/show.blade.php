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
        <p class="item-detail__price">
            ¥{{ number_format($item->price) }} <span class="tax-included">（税込）</span>
        </p>

    <!-- ⭐いいね / 💬コメント 表示 -->
    <div class="item-detail__meta">
        @auth
            @if ($item->isLikedBy(auth()->user()))
                <div class="like-wrapper">
                    <form action="{{ route('items.unlike', $item->id) }}" method="POST" class="inline-form">
                        @csrf @method('DELETE')
                        <button type="submit" class="like-icon liked">★ {{ $likesCount }}</button>
                    </form>
                </div>
            @else
                <div class="like-wrapper">
                    <form action="{{ route('items.like', $item->id) }}" method="POST" class="inline-form">
                        @csrf
                        <button type="submit" class="like-icon">☆ {{ $likesCount }}</button>
                    </form>
                </div>
            @endif
        @else
            <div class="like-wrapper">
                <span class="like-icon disabled">☆ {{ $likesCount }}</span>
            </div>
        @endauth

        <div class="comment-wrapper">
            <span class="comment-icon">💬 {{ $commentsCount }}</span>
        </div>
    </div>

        <form action="{{ route('items.purchase', $item->id) }}" method="GET">
            <button type="submit" class="button-red">購入手続きへ</button>
        </form>

        <!-- 商品説明 -->
        <div class="item-detail__section">
            <h3>商品説明</h3>
            <p>{{ $item->description }}</p>
        </div>

        <!-- 商品の情報 -->
        <div class="item-detail__section">
            <h3>商品の情報</h3>
            <p><strong>カテゴリ：</strong>
                @if ($item->categories->isNotEmpty())
                    @foreach ($item->categories as $category)
                        <span class="badge">{{ $category->name }}</span>
                    @endforeach
                @else
                    <span class="badge">未設定</span>
                @endif
            </p>
            <p><strong>商品の状態：</strong>
                @switch($item->condition)
                    @case(1) 良好 @break
                    @case(2) 目立った傷や汚れなし @break
                    @case(3) やや傷や汚れあり @break
                    @case(4) 状態が悪い @break
                    @default 未設定
                @endswitch
            </p>
        </div>

        <!-- コメント一覧 -->
        <div class="comment-list">
            <h3>コメント（{{ $commentsCount }}）</h3>
            @forelse ($item->comments as $comment)
                <div class="comment-item">
                    <div class="comment-user">
                        <div class="user-icon"></div>
                        <span class="user-name">{{ $comment->user->name }}</span>
                    </div>
                    <div class="comment-content">{{ $comment->content }}</div>
                </div>
            @empty
                <p class="no-comments">まだコメントはありません</p>
            @endforelse
        </div>

        <!-- コメントフォーム -->
        <div class="comment-form">
            @auth
                <form action="{{ route('comments.store', $item->id) }}" method="POST">
                    @csrf
                    <textarea name="content" required placeholder="商品のコメントを入力してください"></textarea>
                    <button type="submit" class="submit-button">コメントを送信する</button>
                </form>
            @else
                <p class="login-notice">コメントするには <a href="{{ route('login') }}">ログイン</a> が必要です。</p>
            @endauth
        </div>

</div>
@endsection
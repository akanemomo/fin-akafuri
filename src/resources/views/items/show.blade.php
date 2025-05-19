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

        <!-- アイコンと購入ボタン -->
        <div class="item-detail__icons">
            <span>⭐︎ {{ $likesCount }}</span>
            <span>💬 {{ $commentsCount }}</span>
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
                @if ($item->category)
                    <span class="badge">{{ $item->category->name }}</span>
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
            <h3>コメント一覧</h3>
            @foreach ($item->comments as $comment)
                <p><strong>{{ $comment->user->name }}</strong>：{{ $comment->content }}</p>
            @endforeach
        </div>

        <!-- コメントフォーム -->
        @auth
        <div class="comment-form">
            <form action="{{ route('comments.store', $item->id) }}" method="POST">
                @csrf
                <textarea name="content" required placeholder="商品のコメントを入力してください"></textarea>
                <button type="submit" class="submit-button">コメントを送信する</button>
            </form>
        </div>

        <!-- いいねボタン -->
        <div class="like-button">
            @if ($item->isLikedBy(auth()->user()))
                <form action="{{ route('items.unlike', $item->id) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="like-btn">★ いいね済み</button>
                </form>
            @else
                <form action="{{ route('items.like', $item->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="like-btn">⭐︎ いいね</button>
                </form>
            @endif
        </div>
        @endauth
    </div>
</div>
@endsection
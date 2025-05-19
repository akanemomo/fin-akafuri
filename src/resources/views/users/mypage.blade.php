@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="mypage-container">
    <h2 class="mypage-title">マイページ</h2>

    <div class="tab-menu">
        <a href="{{ route('mypage', ['tab' => 'buy']) }}" class="tab {{ request('tab') === 'buy' ? 'active' : '' }}">購入一覧</a>
        <a href="{{ route('mypage', ['tab' => 'sell']) }}" class="tab {{ request('tab') === 'sell' ? 'active' : '' }}">出品一覧</a>
    </div>

    <div class="tab-content">
        @if (request('tab') === 'sell')
            <h3>出品した商品</h3>
            @forelse ($sellItems as $item)
                <div class="item-card">
                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="商品画像">
                    <div class="item-info">
                        <p>{{ $item->name }}</p>
                        <p>\{{ number_format($item->price) }}</p>
                        <p>{{ $item->is_sold ? 'SOLD' : '販売中' }}</p>
                    </div>
                </div>
            @empty
                <p>出品した商品はありません。</p>
            @endforelse

        @else
            <h3>購入した商品</h3>
            @forelse ($buyItems as $item)
                <div class="item-card">
                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="商品画像">
                    <div class="item-info">
                        <p>{{ $item->name }}</p>
                        <p>\{{ number_format($item->price) }}</p>
                    </div>
                </div>
            @empty
                <p>購入した商品はありません。</p>
            @endforelse
        @endif
    </div>
</div>
@endsection

@extends('layouts.app')

@php
    use Illuminate\Support\Str;
@endphp

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="mypage-container">

    <!-- プロフィールエリア -->
    <div class="profile-header">
        <div class="profile-image">
        @if (Auth::user()->image_path)
            <img src="{{ asset('storage/' . Auth::user()->image_path) }}" alt="プロフィール画像">
        @else
            <div class="no-image">画像なし</div>
        @endif
        </div>
        <div class="profile-info">
            <h2 class="user-name">{{ Auth::user()->name }}</h2>
            <a href="{{ route('mypage.edit') }}" class="edit-profile-btn">プロフィールを編集</a>
        </div>
    </div>

    <!-- タブ切り替え -->
    <div class="tab-menu">
        <a href="{{ route('mypage', ['tab' => 'sell']) }}" class="tab {{ request('tab') === 'sell' ? 'active' : '' }}">出品した商品</a>
        <a href="{{ route('mypage', ['tab' => 'buy']) }}" class="tab {{ request('tab') === 'buy' ? 'active' : '' }}">購入した商品</a>
    </div>

    <!-- タブコンテンツ -->
    <div class="tab-content">
        @if (request('tab') === 'buy')
            <div class="items-grid">
                @forelse ($buyItems as $item)
                    <div class="item-card">
                        @if ($item && $item->image_path)
                        <img src="{{ Str::startsWith($item->image_path, 'http')
                                ? $item->image_path
                                : asset('storage/' . $item->image_path) }}"
                            alt="商品画像">

                        @else
                            <div class="no-image">画像なし</div>
                        @endif
                        <p class="item-name">{{ $item->name }}</p>
                    </div>
                @empty
                    <p>購入した商品はありません。</p>
                @endforelse
            </div>
        @else
            <div class="items-grid">
                @forelse ($sellItems as $item)
                    <div class="item-card">
                        @if ($item && $item->image_path)
                        <img src="{{ Str::startsWith($item->image_path, 'http')
                                ? $item->image_path
                                : asset('storage/' . $item->image_path) }}"
                            alt="商品画像">

                        @else
                            <div class="no-image">画像なし</div>
                        @endif
                        <p class="item-name">{{ $item->name }}</p>
                        <p class="item-status">{{ $item->is_sold ? 'SOLD' : '販売中' }}</p>
                    </div>
                @empty
                    <p>出品した商品はありません。</p>
                @endforelse
            </div>
        @endif
    </div>
</div>
@endsection

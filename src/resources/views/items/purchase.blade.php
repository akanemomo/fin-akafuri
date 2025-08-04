@extends('layouts.app')

@php
use Illuminate\Support\Str;
@endphp

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<div class="purchase-container">
    <h1 class="page-title">商品購入画面</h1>

    <!-- 購入フォーム -->
    <form action="{{ route('items.buy', $item->id) }}" method="POST">
        @csrf

        <div class="purchase-content">
            <!-- 左側：商品情報とフォーム -->
            <div class="purchase-left">
                <div class="item-info">
                    <img
                        src="{{ Str::startsWith($item->image_path, 'http') ? $item->image_path : asset('storage/' . $item->image_path) }}"
                        alt="商品画像"
                        class="item-image">
                    <div class="item-text">
                        <h2 class="item-name">{{ $item->name }}</h2>
                        <p class="item-price">¥{{ number_format($item->price) }}</p>
                    </div>
                </div>

                <!-- 支払い方法 -->
                <div class="form-block">
                    <label for="payment_method">支払い方法</label>
                    <select name="payment_method" id="payment_method">
                        <option value="">選択してください</option>
                        <option value="credit">クレジットカード</option>
                        <option value="convenience">コンビニ払い</option>
                    </select>
                    @error('payment_method')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 配送先 -->
                <div class="form-block">
                    <div class="address-header">
                        <label>配送先</label>
                        <a href="{{ route('items.editAddress', $item->id) }}" class="change-link">変更する</a>
                    </div>
                    <div class="address">
                        @if (Auth::check())
                            @if (Auth::user()->postal_code && Auth::user()->address)
                                <p>〒{{ Auth::user()->postal_code }}</p>
                                <p>{{ Auth::user()->address }} {{ Auth::user()->building }}</p>
                            @else
                                <p>住所情報が登録されていません。</p>
                            @endif
                        @else
                            <p>ログインしてください。</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- 右側：金額・支払い方法のまとめ -->
            <div class="purchase-summary">
                <div class="summary-box">
                    <p>商品代金：<span>¥{{ number_format($item->price) }}</span></p>
                </div>
                <div class="summary-box">
                    <p>支払い方法：<span id="selected-method">選択してください</span></p>
                </div>
            </div>

            <!-- 枠外に購入ボタンを配置 -->
            <button type="submit" class="purchase-button">購入する</button>

        </div>

    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('payment_method');
        const display = document.getElementById('selected-method');

        if (select && display) {
            select.addEventListener('change', function () {
                display.textContent = this.options[this.selectedIndex].text;
            });
        }
    });
</script>
@endsection

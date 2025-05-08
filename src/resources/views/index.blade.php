@extends('layouts.app')

@php
use Illuminate\Support\Str;
@endphp

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="item-list__content">
    <h1>商品一覧</h1>

    <div class="item-list">
        @foreach($items as $item)
        <a href="{{ route('items.show', $item->id) }}" class="item-link">
            <div class="item-card">
                <!-- 商品画像 -->
                <div class="item-card__image-box">
                    @if ($item->image_path)
                        @if (Str::startsWith($item->image_path, 'http'))
                            <img src="{{ $item->image_path }}" alt="商品画像" class="item-card__image">
                        @else
                            <img src="{{ asset('storage/' . $item->image_path) }}" alt="商品画像" class="item-card__image">
                        @endif
                    @else
                        <span class="image-label">画像なし</span>
                    @endif
                </div>

                <!-- 商品名と価格 -->
                <h3 class="item-card__name">
                    {{ $item->name }}
                    @if ($item->is_sold)
                        <span class="sold-label">SOLD</span>
                    @endif
                </h3>
                <p class="item-card__price">¥{{ number_format($item->price) }}</p>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endsection

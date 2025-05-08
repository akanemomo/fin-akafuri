@extends('layouts.app')

{{-- CSS読み込み（住所変更画面用） --}}
@section('css')
<link rel="stylesheet" href="{{ asset('css/edit_address.css') }}">
@endsection

@section('content')
<div class="address-form__wrapper">
    {{-- ページタイトル --}}
    <h2 class="address-form__title">お届け先住所の変更</h2>

    {{-- 住所変更フォーム --}}
    <form action="{{ route('items.updateAddress', $item->id) }}" method="POST" class="address-form">
        @csrf

        {{-- 名前入力 --}}
        <div class="form-group">
            <label for="name">お名前</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}">
            @error('name')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- 郵便番号入力（形式チェック付き） --}}
        <div class="form-group">
            <label for="postal_code">郵便番号（例: 123-4567）</label>
            <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code') }}">
            @error('postal_code')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- 住所入力 --}}
        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" id="address" name="address" value="{{ old('address') }}">
            @error('address')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- 建物名入力（必須に変更） --}}
        <div class="form-group">
            <label for="building">建物名</label>
            <input type="text" id="building" name="building" value="{{ old('building') }}">
            @error('building')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- 送信ボタン --}}
        <button type="submit" class="submit-button">変更する</button>
    </form>
</div>
@endsection
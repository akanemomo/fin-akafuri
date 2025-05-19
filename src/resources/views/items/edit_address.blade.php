@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/edit_address.css') }}">
@endsection

@section('content')
<div class="address-form__wrapper">
    <h2 class="address-form__title">住所の変更</h2>

    <form action="{{ route('items.updateAddress', $item->id) }}" method="POST" class="address-form">
        @csrf

        {{-- 郵便番号 --}}
        <div class="form-group">
            <label for="postal_code">郵便番号</label>
            <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code') }}">
            @error('postal_code')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- 住所 --}}
        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" id="address" name="address" value="{{ old('address') }}">
            @error('address')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- 建物名 --}}
        <div class="form-group">
            <label for="building">建物名</label>
            <input type="text" id="building" name="building" value="{{ old('building') }}">
            @error('building')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- 更新ボタン --}}
        <div class="form-group">
            <button type="submit" class="submit-button">更新する</button>
        </div>
    </form>
</div>
@endsection
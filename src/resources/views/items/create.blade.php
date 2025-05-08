@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endsection

@section('content')
<div class="exhibit-container">
    <h2 class="exhibit-title">商品の出品</h2>

    <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data" class="exhibit-form">
        @csrf

        <!-- 商品画像 -->
        <div class="form-group">
            <label class="form-label">商品画像</label>
            <div class="image-upload">
                <label for="image" class="upload-button">画像を選択する</label>
                <input type="file" id="image" name="image" hidden>
            </div>
            @error('image')
                <p class="form-error">{{ $message }}</p>
                @enderror
        </div>


        <!-- カテゴリー -->
        <div class="form-group">
            <label>カテゴリー</label>
            <div class="category-buttons">
                @foreach($categories as $index => $category)
                    <label class="category-button">
                        <input type="radio" name="category_id" value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'checked' : '' }}>
                        {{ $category->name }}
                    </label>

                    {{-- 1列目（6個目）と2列目（12個目）のあとに改行 --}}
                    @if ($index == 5 || $index == 11)
                        <div class="break"></div>
                    @endif
                @endforeach
            </div>
        @error('category_id')
            <p class="form-error">{{ $message }}</p>
        @enderror
        </div>

        <!-- 商品の状態 -->
        <div class="form-group">
            <label>商品の状態</label>
            <select name="condition">
                <option disabled selected>選択してください</option>
                <option value="1" {{ old('condition') == 1 ? 'selected' : '' }}>目立った傷や汚れなし</option>
                <option value="2" {{ old('condition') == 2 ? 'selected' : '' }}>やや傷や汚れあり</option>
                <option value="3" {{ old('condition') == 3 ? 'selected' : '' }}>状態が悪い</option>
            </select>
            @error('condition')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- 商品名 -->
        <div class="form-group">
            <label>商品名</label>
            <input type="text" name="name" value="{{ old('name') }}">
            @error('name')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- ブランド名（任意）-->
        <div class="form-group">
            <label>ブランド名</label>
            <input type="text" name="brand" value="{{ old('brand') }}">
        </div>

        <!-- 商品説明 -->
        <div class="form-group">
            <label>商品の説明</label>
            <textarea name="description">{{ old('description') }}</textarea>
            @error('description')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- 販売価格 -->
        <div class="form-group">
            <label>販売価格</label>
            <div class="price-input-wrapper">
                <span class="price-yen">¥</span>
                <input type="number" name="price" value="{{ old('price') }}" class="price-input">
        </div>
        @error('price')
            <p class="form-error">{{ $message }}</p>
        @enderror
        </div>

        <button type="submit" class="submit-button">出品する</button>
    </form>
</div>
@endsection

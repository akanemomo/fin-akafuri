@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile_edit.css') }}">
@endsection

@section('content')
<div class="profile-edit__container">
    <h2 class="page-title">プロフィール設定</h2>

    <form action="{{ route('mypage.update') }}" method="POST" enctype="multipart/form-data" class="profile-edit__form">
    @csrf

        <!-- プロフィール画像と選択ボタンを横並び -->
        <div class="form-group image-group">
            <img src="{{ $user->image_path ? asset('storage/' . $user->image_path) : asset('images/noimage.png') }}"
                alt="プロフィール画像"
                class="profile-image"> {{-- ✅ クラスを修正 --}}

            <label for="image_path" class="image-upload-button">
                画像を選択する
                <input type="file" id="image_path" name="image_path" accept="image/*" hidden>
            </label>

            @error('image_path')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- ユーザー名 -->
        <div class="form-group">
            <label for="name">ユーザー名</label>
            <input type="text" id="name" name="name"
                value="{{ old('name', $user->name) }}">
            @error('name')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- 郵便番号 -->
        <div class="form-group">
            <label for="postal_code">郵便番号</label>
            <input type="text" id="postal_code" name="postal_code"
                value="{{ old('postal_code', $user->postal_code) }}">
            @error('postal_code')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- 住所 -->
        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" id="address" name="address"
                value="{{ old('address', $user->address) }}">
            @error('address')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- 建物名 -->
        <div class="form-group">
            <label for="building">建物名</label>
            <input type="text" id="building" name="building"
                value="{{ old('building', $user->building) }}">
            @error('building')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="submit-btn">更新する</button>
    </form>
</div>
@endsection

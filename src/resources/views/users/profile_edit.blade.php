@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile_edit.css') }}">
@endsection

@section('content')
<div class="profile-edit__container">
    <h2 class="page-title">プロフィール設定</h2>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="profile-edit__form">
        @csrf
        @method('POST')

        <!-- プロフィール画像 -->
        <div class="form-group image-group">
            <label for="image">プロフィール画像</label><br>
            <input type="file" id="image" name="image">
            @error('image')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- ユーザー名 -->
        <div class="form-group">
            <label for="name">ユーザー名</label>
            <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}">
            @error('name')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- 郵便番号 -->
        <div class="form-group">
            <label for="postal_code">郵便番号</label>
            <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', Auth::user()->postal_code) }}">
            @error('postal_code')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- 住所 -->
        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" id="address" name="address" value="{{ old('address', Auth::user()->address) }}">
            @error('address')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- 建物名 -->
        <div class="form-group">
            <label for="building">建物名</label>
            <input type="text" id="building" name="building" value="{{ old('building', Auth::user()->building) }}">
            @error('building')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="submit-button">更新する</button>
    </form>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="exhibit-container">
    <h2 class="exhibit-title">商品の編集</h2>

    @auth
    <!-- ✅ エラー表示 -->
    @if ($errors->any())
        <div class="alert alert-danger" style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="exhibit-form">
        @csrf
        @method('PUT')

        <!-- 商品名 -->
        <div class="form-block">
            <label for="name">商品名</label>
            <input type="text" name="name" value="{{ old('name', $item->name) }}">
        </div>

        <!-- 画像 -->
        <div class="form-block">
            <label for="image">商品画像</label>
            <input type="file" name="image">
            @if($item->image_path)
                <p>現在の画像: <img src="{{ asset('storage/' . $item->image_path) }}" width="100"></p>
            @endif
        </div>

        <!-- カテゴリ（複数選択対応）-->
        <div class="form-block">
            <label for="categories">カテゴリ</label>
            <select name="categories[]" multiple>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ (collect(old('categories', $item->categories->pluck('id')))->contains($category->id)) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- 価格 -->
        <div class="form-block">
            <label for="price">価格</label>
            <input type="number" name="price" value="{{ old('price', $item->price) }}">
        </div>

        <button type="submit" class="btn">更新する</button>
    </form>
    @endauth
</div>
@endsection

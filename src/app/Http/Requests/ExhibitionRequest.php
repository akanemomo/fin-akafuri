<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    public function authorize(): bool
    {
        // 認証済みユーザーなら true にする
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png', // ← 修正済
            'categories' => 'required|array',            // ← 複数カテゴリ対応
            'categories.*' => 'integer|exists:categories,id',
            'condition' => 'required|integer|in:1,2,3',
            'price' => 'required|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => '商品名は必須です。',
            'description.required' => '商品説明は必須です。',
            'description.max' => '商品説明は255文字以内で入力してください。',
            'image.image' => '商品画像は画像ファイルである必要があります。',
            'image.mimes' => '商品画像はjpegまたはpng形式である必要があります。',
            'categories.required' => '商品カテゴリーは選択必須です。',
            'categories.*.exists' => '選択されたカテゴリーが無効です。',
            'condition.required' => '商品の状態は選択必須です。',
            'condition.integer' => '商品の状態は数値で指定してください。',
            'price.required' => '商品価格は必須です。',
            'price.integer' => '商品価格は数値で入力してください。',
            'price.min' => '商品価格は0円以上で入力してください。',
        ];
    }
}

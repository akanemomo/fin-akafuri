<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true; // 認証ユーザーならOK
    }

    public function rules()
    {
        return [
            'image_path' => 'nullable|mimes:jpeg,png', // 画像は必須じゃないけど、拡張子制限あり
            'name' => 'required|string|max:255',
            'postal_code' => 'required|regex:/^\d{3}-\d{4}$/',
            'address' => 'required|string|max:255',
            'building' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'image_path.mimes' => 'プロフィール画像は.jpegまたは.png形式でアップロードしてください。',
            'name.required' => 'ユーザー名は必須です。',
            'postal_code.required' => '郵便番号は必須です。',
            'postal_code.regex' => '郵便番号は「123-4567」の形式で入力してください。',
            'address.required' => '住所は必須です。',
            'building.required' => '建物名は必須です。',
        ];
    }
}

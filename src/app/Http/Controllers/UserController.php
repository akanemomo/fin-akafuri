<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileRequest;

class UserController extends Controller
{
    public function edit()
    {
        return view('users.profile_edit');
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();

        // 画像があれば保存
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('profile-img', 'public');
            $data['image_path'] = $path;
        }

        // プロフィールを更新
        $user->update([
            'name' => $data['name'],
            'postal_code' => $data['postal_code'],
            'address' => $data['address'],
            'building' => $data['building'],
            'image_path' => $data['image_path'] ?? $user->image_path,
            'is_profile_set' => true,
        ]);

        return redirect('/mypage')->with('success', 'プロフィールを更新しました！');
    }

    public function mypage()
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'ログインしてください');
        }

        $user = Auth::user();

        $buyItems = $user->buyItems()->latest()->get();   // 購入商品一覧
        $sellItems = $user->items()->latest()->get();     // 出品商品一覧

        return view('users.mypage', compact('buyItems', 'sellItems'));
    }
}
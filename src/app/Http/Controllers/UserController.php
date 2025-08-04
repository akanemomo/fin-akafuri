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
        $user = Auth::user();
        return view('users.profile_edit', compact('user'));
    }

    public function update(ProfileRequest $request)
    {
        $user = auth()->user();

        // 画像があれば保存
        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('profiles', 'public');
            $user->image_path = $path;
        }

        // プロフィールを更新
        $user->name = $request->name;
        $user->postal_code = $request->postal_code;
        $user->address = $request->address;
        $user->building = $request->building;
        $user->save();

        return redirect('/mypage')->with('success', 'プロフィールを更新しました！');
    }

    public function mypage()
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'ログインしてください');
        }

        $user = Auth::user();

        // 購入商品（Item一覧を取得）
        $buyItems = $user->buyItems()->latest()->get();

        // 出品商品
        $sellItems = $user->items()->latest()->get();

        return view('users.mypage', compact('buyItems', 'sellItems'));
    }

    public function updateAddress(Request $request, $item_id)
    {
        $user = Auth::user();

        $user->postal_code = $request->postal_code;
        $user->address = $request->address;
        $user->building = $request->building;
        $user->save();

        return redirect()->route('items.purchase', ['item' => $item_id]);
    }
}

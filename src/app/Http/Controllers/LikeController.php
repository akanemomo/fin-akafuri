<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class LikeController extends Controller
{
    public function store(Item $item)
    {
        $user = auth()->user();

        // まだいいねしていない場合のみ登録
        if (!$item->isLikedBy($user)) {
            $item->likes()->attach($user->id);
        }

        return back(); // 商品詳細ページに戻る
    }

    public function destroy(Item $item)
    {
        $user = auth()->user();

        // いいね済みの場合のみ解除
        if ($item->isLikedBy($user)) {
            $item->likes()->detach($user->id);
        }

        return back(); // 商品詳細ページに戻る
    }
}
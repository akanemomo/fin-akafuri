<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ExhibitionRequest;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\PurchaseRequest;
use App\Models\Item;
use App\Models\Category;

class ItemController extends Controller
{
    /**
     * 商品出品処理
     */
    public function store(ExhibitionRequest $request)
    {
        // バリデーション済みのデータを取得
        $data = $request->validated();

        // 画像がアップロードされていれば保存し、パスを格納
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('fruits-img', 'public');
            $data['image_path'] = $path;
        }

        // ログインユーザーのIDを出品者として登録
        $data['user_id'] = auth()->id();

        // 商品登録
        Item::create($data);

        // 商品一覧ページにリダイレクト
        return redirect('/')->with('success', '商品を出品しました！');
    }

    /**
     * 商品一覧表示
     */
    public function index()
    {
        $items = Item::all();
        return view('index', compact('items'));
    }

    /**
     * 出品フォームの表示
     */
    public function create()
    {
        $categories = Category::all(); // カテゴリ一覧を取得
        return view('items.create', compact('categories'));
    }

    /**
     * 商品詳細ページの表示
     */
    public function show(Item $item)
    {
        $likesCount = $item->likes()->count(); // 例: likesリレーションがある場合
        $commentsCount = $item->comments()->count(); // 例: commentsリレーションがある場合

        return view('items.show', compact('item', 'likesCount', 'commentsCount'));
    }

    /**
     * 購入画面の表示
     */
    public function purchase(Item $item)
    {
        return view('items.purchase', compact('item'));
    }

    /**
     * 住所変更画面の表示（購入前）
     */
    public function editAddress(Item $item)
    {
        return view('items.edit_address', compact('item'));
    }

    /**
     * 住所変更の処理（バリデーション含む）
     */
    public function updateAddress(AddressRequest $request, Item $item)
    {
        // バリデーション済みデータを取得
        $validated = $request->validated();

        // セッションに一時保存（通常はDBに保存）
        session([
            'address.postal_code' => $validated['postal_code'],
            'address.address' => $validated['address'],
            'address.building' => $validated['building'],
        ]);

        // 購入画面へリダイレクト
        return redirect()->route('items.purchase', $item->id)->with('success', '住所を更新しました');
    }

    public function buy(PurchaseRequest $request, Item $item)
    {
        // バリデーション済みデータ
        $validated = $request->validated();

        // 商品を購入済みにする
        $item->is_sold = true;
        $item->save();

        // リダイレクト
        return redirect()->route('items.index')->with('success', '購入が完了しました！');
    }
}

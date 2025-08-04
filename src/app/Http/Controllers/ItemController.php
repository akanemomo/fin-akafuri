<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ExhibitionRequest;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\PurchaseRequest;
use App\Models\Item;
use App\Models\Category;
use App\Models\Order;

class ItemController extends Controller
{
    /**
     * 商品出品処理
     */
    public function store(ExhibitionRequest $request)
    {
        $data = $request->validated();

        // 画像を保存
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('fruits-img', 'public');
            $data['image_path'] = $path;
        }

        // ユーザーIDを追加
        $data['user_id'] = auth()->id();

        // categories は一旦除外（itemsテーブルには直接保存しない）
        $categories = $data['categories'] ?? [];
        unset($data['categories']);

        // Itemを保存（カテゴリ以外）
        $item = Item::create($data);

        // カテゴリを中間テーブルに保存（複数対応）
        if (!empty($categories)) {
            $item->categories()->sync($categories);
        }

        // ✅ 出品後は商品一覧へリダイレクト
        return redirect()->route('items.index')
                        ->with('success', '商品を出品しました！');
    }

    /**
     * 商品一覧表示
     */
    public function index(Request $request)
    {
        $queryPage = $request->query('page');

        if ($queryPage === 'mylist') {
            $items = auth()->check()
                    ? auth()->user()->likes()->with('item')->get()->pluck('item')
                    : collect();
        } else {
            $items = Item::query()
                ->when(auth()->check(), fn($q) => $q->where('user_id', '!=', auth()->id()))
                ->latest()
                ->get();
        }

        return view('index', compact('items'));
    }

    /**
     * 出品フォームの表示
     */
    public function create()
    {
        $categories = Category::all();
        return view('items.create', compact('categories'));
    }

    /**
     * 商品編集フォームの表示
     */
    public function edit(Item $item)
    {
        $categories = Category::all();
        return view('items.edit', compact('item', 'categories'));
    }

    /**
     * 商品更新処理
     */
    public function update(ExhibitionRequest $request, Item $item)
    {
        $data = $request->validated();

        // 画像更新（新しい画像があれば差し替え）
        if ($request->hasFile('image')) {
            // 古い画像を削除（必要なら）
            if ($item->image_path && Storage::disk('public')->exists($item->image_path)) {
                Storage::disk('public')->delete($item->image_path);
            }
            $path = $request->file('image')->store('fruits-img', 'public');
            $data['image_path'] = $path;
        }

        // categories は一旦除外
        $categories = $data['categories'] ?? [];
        unset($data['categories']);

        // 商品を更新
        $item->update($data);

        // カテゴリも更新
        $item->categories()->sync($categories);

        return redirect()->route('items.index')->with('success', '商品を更新しました！');
    }

    /**
     * 商品詳細ページの表示
     */
    public function show(Item $item)
    {
        $likesCount = $item->likes()->count();
        $commentsCount = $item->comments()->count();

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
     * 住所変更の処理
     */
    public function updateAddress(AddressRequest $request, Item $item)
    {
        $validated = $request->validated();

        session([
            'address.postal_code' => $validated['postal_code'],
            'address.address' => $validated['address'],
            'address.building' => $validated['building'],
        ]);

        return redirect()->route('items.purchase', $item->id)->with('success', '住所を更新しました');
    }

    /**
     * 商品購入処理
     */
    public function buy(PurchaseRequest $request, Item $item)
    {
        $validated = $request->validated();

        // 商品を購入済みにする
        $item->is_sold = true;
        $item->save();

        // 注文を登録
        Order::create([
            'user_id' => auth()->id(),
            'item_id' => $item->id,
            'payment_method' => $validated['payment_method'],
            'address' => auth()->user()->address ?? '未設定住所',
        ]);

        return redirect()->route('items.index')->with('success', '購入が完了しました！');
    }
}


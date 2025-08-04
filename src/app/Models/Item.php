<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand',
        'description',
        'image_path',
        'condition',
        'price',
        'user_id',
    ];

    // 👍 いいね機能（多対多）
    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }

    public function isLikedBy($user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    // 👍 コメント機能（1対多）
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // 👍 出品者（多対1）
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 👍 カテゴリ（多対多）※中間テーブル category_item を使用
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_item');
    }
}

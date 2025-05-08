<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('items', function (Blueprint $table) {
        $table->id(); // PRIMARY KEY
        $table->unsignedBigInteger('user_id'); // 出品者
        $table->string('name'); // 商品名
        $table->string('brand')->nullable(); // ブランド名（任意）
        $table->text('description'); // 商品説明
        $table->unsignedBigInteger('category_id'); // カテゴリー
        $table->tinyInteger('condition'); // 商品の状態
        $table->integer('price'); // 販売価格
        $table->string('image_path')->nullable(); // 画像パス（任意）
        $table->timestamps(); // created_at, updated_at

        // 外部キー制約
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}

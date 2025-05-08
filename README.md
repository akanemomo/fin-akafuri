# Furima

## 環境構築

### Docker ビルド

```
git clone <リポジトリURL>
docker-compose up -d --build
```

### Laravel 環境構築

```
docker-compose exec php bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
composer require doctrine/dbal  # カラム名変更などに使用
```

## 使用技術（実行環境）

- PHP: 7.4.9
- Laravel: 8.83.8
- MySQL: 8.0.34
- nginx: バージョン未記入
- Fortify: ログイン機能に使用

## 開発用 URL（仕様ベース、未実装の画面も含む）

- 商品一覧画面（トップ画面）：http://localhost/
- 商品一覧画面（マイリスト）：http://localhost/?tab=mylist ※未実装
- 会員登録画面：http://localhost/register
- ログイン画面：http://localhost/login
- 商品詳細画面：http://localhost/item/:item_id
- 商品購入画面：http://localhost/purchase/:item_id ※未実装
- 住所変更ページ：http://localhost/purchase/address/:item_id ※未実装
- 商品出品画面：http://localhost/sell
- プロフィール画面：http://localhost/mypage ※未実装
- プロフィール編集画面：http://localhost/mypage/profile ※未実装
- 購入済み商品一覧：http://localhost/mypage?tab=buy ※未実装
- 出品済み商品一覧：http://localhost/mypage?tab=sell ※未実装
- phpMyAdmin：http://localhost:8080

## ER 図

（ここに ER 図の画像を貼る）

## 実装済み機能

- 商品一覧表示
- 商品詳細ページ
- 商品出品機能
- いいね機能（登録・解除、いいね数表示）
- コメント送信機能（ログインユーザーのみ、バリデーションあり、コメント数表示）

## 今後の予定（例）

- 商品購入機能
- プロフィール編集機能
- 検索／絞り込み機能

---

以上が **Furima** の初期セットアップおよび実装概要です。

# もぎたて - フルーツスムージー商品管理アプリケーション

「もぎたて」は、フルーツスムージーショップの商品を管理するためのWebアプリケーションです。商品の登録、編集、検索、並び替え機能を提供し、季節ごとの商品分類も可能です。

## 目次

- [環境構築](#環境構築)
- [使用技術（実行環境）](#使用技術実行環境)
- [ER図](#er図)
- [URL設計](#url設計)
- [機能一覧](#機能一覧)

## 環境構築

### 必要条件

- Docker
- Docker Compose
- Git

### インストール手順

1. リポジトリをクローンします

```bash
git clone https://github.com/yourusername/mogitate.git
cd mogitate
```

2. Dockerコンテナをビルド・起動します

```bash
docker-compose up -d
```

3. 依存パッケージをインストールします

```bash
docker-compose exec php composer install
```

4. .envファイルを作成します

```bash
cp src/.env.example src/.env
docker-compose exec php php artisan key:generate
```

5. 環境設定を編集します (.env)

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```

6. データベースのマイグレーションとシードを実行します

```bash
docker-compose exec php php artisan migrate:fresh --seed
```

7. ストレージのシンボリックリンクを作成します（必要に応じて）

```bash
docker-compose exec php php artisan storage:link
```

8. http://localhost にアクセスして、アプリケーションが正常に動作していることを確認します

## 使用技術（実行環境）

### フロントエンド
- HTML / CSS
- JavaScript

### バックエンド
- PHP 7.4.9
- Laravel 8.x

### インフラ
- Docker / Docker Compose
- Nginx 1.21.1
- MySQL 8.0.26
- PHPMyAdmin

### 開発環境
- Docker環境で開発
- MySQL用のデータボリューム
- Nginxによるリバースプロキシ

## ER図

```
    +----------------+        +----------------+        +-----------------+
    |    products    |        |product_season  |        |     seasons     |
    +----------------+        +----------------+        +-----------------+
    | id             |<---+   | id             |   +-->| id              |
    | name           |    |   | product_id     |   |   | name            |
    | price          |    +---| season_id      |---+   | created_at      |
    | image          |        | created_at     |       | updated_at      |
    | description    |        | updated_at     |       +-----------------+
    | created_at     |        +----------------+
    | updated_at     |
    +----------------+
```

### テーブル構成

#### products テーブル
| カラム名 | 型 | 説明 |
|---------|-----|-----|
| id | bigint(20) unsigned | 主キー |
| name | varchar(255) | 商品名 |
| price | int(11) | 価格 |
| image | varchar(255) | 画像パス |
| description | text | 商品説明 |
| created_at | timestamp | 作成日時 |
| updated_at | timestamp | 更新日時 |

#### seasons テーブル
| カラム名 | 型 | 説明 |
|---------|-----|-----|
| id | bigint(20) unsigned | 主キー |
| name | varchar(255) | 季節名 |
| created_at | timestamp | 作成日時 |
| updated_at | timestamp | 更新日時 |

#### product_season テーブル (中間テーブル)
| カラム名 | 型 | 説明 |
|---------|-----|-----|
| id | bigint(20) unsigned | 主キー |
| product_id | bigint(20) unsigned | 外部キー（productsテーブル） |
| season_id | bigint(20) unsigned | 外部キー（seasonsテーブル） |
| created_at | timestamp | 作成日時 |
| updated_at | timestamp | 更新日時 |

### リレーション
- productsテーブルとseasonsテーブルは多対多の関係
- product_seasonテーブルが中間テーブルとして機能

## URL設計

| HTTPメソッド | URL | コントローラー | 機能 |
|---------|-----|-------------|-----|
| GET | / | - | 商品一覧にリダイレクト |
| GET | /products | ProductController@products | 商品一覧を表示 |
| GET | /products/register | ProductController@create | 商品登録フォームを表示 |
| POST | /products/register | ProductController@store | 商品を登録 |
| GET | /products/search | ProductController@search | 商品を検索 |
| GET | /products/{productId} | ProductController@show | 商品詳細を表示 |
| GET | /products/{productId}/update | ProductController@edit | 商品編集フォームを表示 |
| PUT | /products/{productId}/update | ProductController@update | 商品を更新 |
| DELETE | /products/{productId}/delete | ProductController@destroy | 商品を削除 |

## 機能一覧

- 商品一覧表示機能
  - 登録されている商品を一覧で表示
  - ページネーション機能（1ページあたり6件表示）

- 検索機能
  - 商品名のキーワード検索

- 並び替え機能
  - 価格の高い順/低い順に並び替え

- 商品登録機能
  - 商品名、価格、季節、説明文、画像を登録

- 商品詳細表示機能
  - 商品の詳細情報を表示

- 商品編集機能
  - 登録済み商品の情報を編集

- 商品削除機能
  - 登録済み商品を削除
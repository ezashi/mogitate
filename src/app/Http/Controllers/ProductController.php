<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
  //商品一覧を表示するメソッド(GETリクエスト: /products)
  public function products(Request $request)
  {
    //Product モデルからクエリビルダーを取得し、関連する seasons も一緒に取得（N+1問題の回避）
    $query = Product::with('seasons');

    //検索機能: キーワードが指定されていれば、商品名の部分一致検索を行う
    if ($request->has('keyword')) {
      $keyword = $request->input('keyword');
      $query->where('name', 'like', "%{$keyword}%"); // SQLのLIKE句を使った部分一致検索
    }

    //並び替え機能: sortパラメータに基づいて価格の昇順/降順で並び替え
    if ($request->has('sort')) {
      $sort = $request->input('sort');
      if ($sort === 'high') {
        $query->orderBy('price', 'desc'); // 高い順（降順）
      }
      elseif ($sort === 'low') {
        $query->orderBy('price', 'asc'); // 低い順（昇順）
      }
    }

    //ページネーション: 1ページあたり6件の商品を表示
    $products = $query->paginate(6);

    //ビューに変数を渡して表示
    return view('products.products', [
      'products' => $products, // ページネーション済み商品コレクション
      'keyword' => $request->input('keyword', ''), // 検索キーワード（デフォルト空文字）
      'sort' => $request->input('sort', '') // 並び替え条件（デフォルト空文字）
    ]);
  }


  //商品登録フォームを表示するメソッド(GETリクエスト: /products/register)
  public function create()
  {
    // すべての季節を取得
    $seasons = Season::all();

    // 登録フォームを表示し、季節データを渡す
    return view('products.register', ['seasons' => $seasons]);
  }


  //商品登録された項目を保存するメソッド(POSTリクエスト: /products/register)
  public function store(ProductRequest $request)
  {
    //ランダムでファイル名を生成（重複防止）
    $filename = Str::random(20) . '.' . $request->file('image')->getClientOriginalExtension();

    // 画像ファイルを/public/images/productsディレクトリに保存
    $request->file('image')->move(public_path('images/products'), $filename);

    // 画像のパスを保存用に設定
    $imagePath = 'images/products/' . $filename;

    // 商品データをデータベースに保存
    $product = Product::create([
      'name' => $request->name, // 商品名
      'price' => $request->price, // 価格
      'description' => $request->description, // 商品説明
      'image' => $imagePath, // 画像のパス
    ]);

    // 中間テーブルに季節データを関連付け
    // $request->seasons は選択された季節IDの配列
    $product->seasons()->attach($request->seasons);

    // 商品一覧ページにリダイレクトし、成功メッセージをフラッシュデータとして追加
    return redirect('/products')->with('success', '商品を登録しました');
  }


  //商品検索を処理するメソッド(GETリクエスト: /products/search)
  public function search(Request $request)
  {
    // 検索キーワードを取得
    $keyword = $request->input('keyword');

    // 商品一覧ページに検索キーワードを付けてリダイレクト
    // products()メソッドで実際の検索処理が行われる
    return redirect()->route('products', ['keyword' => $keyword]);
  }


  //商品詳細を表示するメソッド(GETリクエスト: /products/{productId})
  public function show($productId)
  {
    // 指定IDの商品を関連する季節と共に取得（存在しない場合は404エラー）
    $product = Product::with('seasons')->findOrFail($productId);

    // 詳細ビューを表示
    return view('products.show', ['product' => $product]);
  }


  //商品更新フォームを表示するメソッド(GETリクエスト: /products/{productId}/update)
  public function edit($productId)
  {
    // 指定IDの商品を関連する季節と共に取得（存在しない場合は404エラー）
    $product = Product::with('seasons')->findOrFail($productId);
    // すべての季節を取得
    $seasons = Season::all();

    // 更新フォームを表示し、商品データと季節データを渡す
    return view('products.update', [
      'product' => $product,
      'seasons' => $seasons
    ]);
  }


  //商品を更新するメソッド(PUTリクエスト: /products/{productId}/update)
  public function update(ProductRequest $request, $productId)
  {
    // 指定IDの商品を取得（存在しない場合は404エラー）
    $product = Product::findOrFail($productId);

    // 画像ファイルの処理
    if ($request->hasFile('image')) {
      // 新しい画像がアップロードされた場合

      // ランダムでファイル名を生成（重複防止）
      $filename = Str::random(20) . '.' . $request->file('image')->getClientOriginalExtension();

      // 画像ファイルを/public/images/productsディレクトリに保存
      $request->file('image')->move(public_path('images/products'), $filename);

      // 画像のパスを更新用に設定
      $imagePath = 'images/products/' . $filename;

      // 古い画像があれば削除
      if ($product->image && file_exists(public_path($product->image))) {
        unlink(public_path($product->image));
      }
    }
    else {
      // 新しい画像がアップロードされていない場合は既存の画像パスを使用
      $imagePath = $product->image;
    }

    // 商品データを更新
    $product->update([
      'name' => $request->name, // 商品名
      'price' => $request->price, // 価格
      'description' => $request->description, // 商品説明
      'image' => $imagePath, // 画像のパス
    ]);

    // 中間テーブルの季節データを更新（既存のデータを一度削除して再登録）
    $product->seasons()->sync($request->seasons);

    // 商品一覧ページにリダイレクトし、成功メッセージをフラッシュデータとして追加
    return redirect('/products')->with('success', '商品を更新しました');
  }


  //商品を削除するメソッド(DELETEリクエスト: /products/{productId}/delete)
  public function destroy($productId)
  {
    // 指定IDの商品を取得（存在しない場合は404エラー）
    $product = Product::findOrFail($productId);

    // 商品に関連する画像ファイルを削除
    if ($product->image && file_exists(public_path($product->image))) {
      unlink(public_path($product->image));
    }

    // 商品を削除（関連する中間テーブルのデータも自動的に削除される）
    $product->delete();

    // 商品一覧ページにリダイレクトし、成功メッセージをフラッシュデータとして追加
    return redirect('/products')->with('success', '商品を削除しました');
  }
}
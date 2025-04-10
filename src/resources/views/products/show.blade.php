@extends('layouts.app')
@section('title', $product->name)
@section('content')
  <!-- 商品詳細 -->
  <div class="product-detail">
    <!-- 商品画像 -->
    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="product-detail-image">

    <!-- 商品名 -->
    <div class="form-group">
      <label class="form-label">商品名</label>
      <div>{{ $product->name }}</div>
    </div>

    <!-- 商品価格 -->
    <div class="form-group">
      <label class="form-label">値段</label>
      <div>¥{{ number_format($product->price) }}</div>
    </div>

    <!-- 季節情報 -->
    <div class="form-group">
      <label class="form-label">季節</label>
      <div class="product-seasons">
        @foreach($product->seasons as $season)
        <span class="season-tag">{{ $season->name }}</span>
        @endforeach
      </div>
    </div>

    <!-- 商品説明 -->
    <div class="form-group">
      <label class="form-label">商品説明</label>
      <div>{{ $product->description }}</div>
    </div>

    <!-- アクションボタン -->
    <div class="action-buttons">
      <!-- 戻るボタン -->
      <a href="{{ route('products') }}" class="btn btn-secondary">戻る</a>

      <!-- 編集ボタン -->
      <a href="{{ route('products.edit', $product->id) }}" class="btn">編集</a>

      <!-- 削除フォーム -->
      <form action="{{ route('products.destroy', $product->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <!-- 削除ボタン -->
        <button type="submit" class="btn btn-danger">削除</button>
      </form>
    </div>
  </div>
@endsection
@extends('layouts.app')
@section('title', $product->name . 'の編集')
@section('content')
  <h2>商品編集</h2>

  <!-- 商品更新フォーム -->
  <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- 商品名入力欄（既存の値をデフォルト値として表示） -->
    <div class="form-group">
      <label for="name" class="form-label">商品名</label>
      <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $product->name) }}">
      @error('name')
      <div class="error-message">{{ $message }}</div>
      @enderror
    </div>

    <!-- 価格入力欄 -->
    <div class="form-group">
      <label for="price" class="form-label">値段</label>
      <input type="number" id="price" name="price" class="form-control" value="{{ old('price', $product->price) }}">
      @error('price')
      <div class="error-message">{{ $message }}</div>
      @enderror
    </div>

    <!-- 季節選択欄 -->
    <div class="form-group">
      <label class="form-label">季節</label>
      <div class="checkbox-group">
        <!-- 現在選択されている季節IDの配列を取得 -->
        @php
        $selectedSeasons = old('seasons', $product->seasons->pluck('id')->toArray());
        @endphp

        <!-- 全季節をループして表示 -->
        @foreach($seasons as $season)
        <div>
          <!-- 現在選択されている季節はチェック済みにする -->
          <input type="checkbox" id="season-{{ $season->id }}" name="seasons[]" value="{{ $season->id }}"{{ in_array($season->id, $selectedSeasons) ? 'checked' : '' }}>
          <label for="season-{{ $season->id }}">{{ $season->name }}</label>
        </div>
        @endforeach
      </div>
      @error('seasons')
      <div class="error-message">{{ $message }}</div>
      @enderror
    </div>

    <!-- 商品説明入力欄 -->
    <div class="form-group">
      <label for="description" class="form-label">商品説明</label>
      <textarea id="description" name="description" class="form-control" rows="5">{{ old('description', $product->description) }}</textarea>
      @error('description')
      <div class="error-message">{{ $message }}</div>
      @enderror
    </div>

    <!-- 商品画像アップロード欄 -->
    <div class="form-group">
      <label for="image" class="form-label">商品画像</label>
      <!-- 既存の画像があれば表示 -->
      @if($product->image)
      <div>
        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="max-width: 200px; margin-bottom: 10px;">
      </div>
      @endif
      <!-- 新しい画像のアップロード欄 -->
      <input type="file" id="image" name="image" class="form-control">
      @error('image')
      <div class="error-message">{{ $message }}</div>
      @enderror
    </div>

    <!-- アクションボタン -->
    <div class="action-buttons">
      <!-- 戻るボタン -->
      <a href="{{ route('products') }}" class="btn btn-secondary">戻る</a>
      <!-- 更新ボタン -->
      <button type="submit" class="btn">変更を保存</button>
      <!-- 削除フォーム -->
      <form action="{{ route('products.destroy', $product->productId) }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <!-- 削除ボタン（ゴミ箱アイコン付き） -->
        <button type="submit" class="btn btn-danger">
          <i class="fas fa-trash"></i> 削除
        </button>
      </form>
    </div>
  </form>
@endsection
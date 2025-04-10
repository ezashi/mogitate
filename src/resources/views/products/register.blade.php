@extends('layouts.app')
@section('title', '商品登録')
@section('content')
  <h2>商品登録</h2>

  <!-- 商品登録フォーム -->
  <!-- enctype="multipart/form-data"はファイルアップロードに必要 -->
  <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" novalidate>
    @csrf

    <!-- 商品名入力欄 -->
    <div class="form-group">
      <label for="name" class="form-label">商品名</label>
      <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" placeholder="商品名を入力">
      @error('name')
      <div class="error-message">{{ $message }}</div>
      @enderror
    </div>

    <!-- 価格入力欄 -->
    <div class="form-group">
      <label for="price" class="form-label">値段</label>
      <input type="number" id="price" name="price" class="form-control" value="{{ old('price') }}" placeholder="値段を入力">
      @error('price')
      <div class="error-message">{{ $message }}</div>
      @enderror
    </div>

    <!-- 季節選択欄 -->
    <div class="form-group">
      <label class="form-label">季節</label>
      <div class="checkbox-group">
        @foreach($seasons as $season)
        <div>
          <!-- チェックボックス（複数選択可能なので name="seasons[]" という配列形式） -->
          <input type="checkbox" id="season-{{ $season->id }}" name="seasons[]" value="{{ $season->id }}"{{ in_array($season->id, old('seasons', [])) ? 'checked' : '' }}>
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
      <textarea id="description" name="description" class="form-control" rows="5" placeholder="商品の説明を入力">{{ old('description') }}</textarea>
      @error('description')
      <div class="error-message">{{ $message }}</div>
      @enderror
    </div>

    <!-- 商品画像アップロード欄 -->
    <div class="form-group">
      <label for="image" class="form-label">商品画像</label>
      <input type="file" id="image" name="image" class="form-control">
      @error('image')
      <div class="error-message">{{ $message }}</div>
      @enderror
    </div>

    <!-- アクションボタン -->
    <div class="action-buttons">
    <!-- 戻るボタン -->
      <a href="{{ route('products') }}" class="btn btn-secondary">戻る</a>
      <!-- 登録ボタン -->
      <button type="submit" class="btn">登録</button>
    </div>
  </form>
@endsection
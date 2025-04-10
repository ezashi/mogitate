@extends('layouts.app')
@section('title', '商品一覧')
@section('content')
  <!-- 商品一覧のヘッダー部分 -->
  <div class="product-header">
    <h2>商品一覧</h2>
    <a href="{{ route('products.create') }}" class="btn">+ 商品を追加</a>
  </div>

  <!-- 検索フォーム -->
  <form action="{{ route('products.search') }}" method="GET" class="search-box">
  <input type="text" name="keyword" class="search-input" placeholder="商品名を入力" value="{{ $keyword }}">
  <button type="submit" class="btn">検索</button>
  </form>

  <!-- 並び替え機能 -->
  <div class="sort-box">
    <!-- select要素の値が変更されたらページ遷移するJavaScriptを実行 -->
    <select name="sort" id="sort-select" class="sort-select" onchange="location.href='{{ route('products') }}?keyword={{ $keyword }}&sort=' + this.value">
      <option value="">並び替え</option>
      <!-- 現在の並び替え条件に基づいてselected属性を設定 -->
      <option value="high" {{ $sort == 'high' ? 'selected' : '' }}>高い順に表示</option>
      <option value="low" {{ $sort == 'low' ? 'selected' : '' }}>低い順に表示</option>
    </select>

    <!-- 並び替え条件が選択されている場合、タグを表示 -->
    @if($sort)
    <span class="sort-tag">
      {{ $sort == 'high' ? '高い順に表示' : '低い順に表示' }}
      <!-- クリックで並び替え条件をクリアするリンク -->
      <a href="{{ route('products', ['keyword' => $keyword]) }}">✕</a>
    </span>
    @endif
  </div>

  <!-- 商品一覧をグリッド表示 -->
  <div class="products-grid">
    @foreach($products as $product)
    <!-- 商品カード（クリックで詳細ページに遷移） -->
    <a href="{{ route('products.show', $product->id) }}" class="product-card">
      <!-- 商品画像（Storageからの表示） -->
      <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
      <div class="product-info">
        <h3 class="product-name">{{ $product->name }}</h3>
        <p class="product-price">¥{{ number_format($product->price) }}</p>
        <div class="product-seasons">
          @foreach($product->seasons as $season)
          <span class="season-tag">{{ $season->name }}</span>
          @endforeach
        </div>
      </div>
    </a>
    @endforeach
  </div>

  <!-- ページネーション -->
  <div class="pagination">
    <!-- 検索キーワードと並び替え条件を保持したままページ切り替え -->
    {{ $products->appends(['keyword' => $keyword, 'sort' => $sort])->links() }}
  </div>
@endsection
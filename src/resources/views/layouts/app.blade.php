<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>もぎたて - @yield('title')</title>
    <style>
        body {
            font-family: 'Hiragino Sans', 'Hiragino Kaku Gothic ProN', Meiryo, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        header {
            background-color: #4CAF50;
            color: white;
            padding: 15px 0;
            text-align: center;
        }
        header h1 {
            margin: 0;
            font-size: 24px;
        }
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .product-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            cursor: pointer;
        }
        .product-card:hover {
            transform: translateY(-5px);
        }
        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .product-info {
            padding: 15px;
        }
        .product-name {
            font-size: 18px;
            font-weight: bold;
            margin: 0 0 10px;
        }
        .product-price {
            font-size: 16px;
            color: #E91E63;
            font-weight: bold;
        }
        .product-seasons {
            display: flex;
            gap: 5px;
            margin-top: 10px;
        }
        .season-tag {
            background: #E8F5E9;
            color: #4CAF50;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 12px;
        }
        .btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }
        .btn-secondary {
            background-color: #6c757d;
        }
        .btn-danger {
            background-color: #dc3545;
        }
        .search-box {
            margin: 20px 0;
            display: flex;
            gap: 10px;
        }
        .search-input {
            flex-grow: 1;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .sort-box {
            margin: 20px 0;
        }
        .sort-select {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .sort-tag {
            display: inline-block;
            background: #f0f0f0;
            padding: 5px 10px;
            border-radius: 4px;
            margin-left: 10px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .error-message {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
        }
        .checkbox-group {
            display: flex;
            gap: 15px;
        }
        .product-detail {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .product-detail-image {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .action-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .pagination {
            margin-top: 30px;
            display: flex;
            justify-content: center;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>もぎたて</h1>
        </div>
    </header>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>
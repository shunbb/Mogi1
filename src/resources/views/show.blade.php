<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $item->name }} - 商品詳細</title>
    <style>
        body { font-family: 'Helvetica Neue', Arial, sans-serif; background-color: #f9f9f9; margin: 0; padding: 0; }
        header { background-color: #fff; border-bottom: 1px solid #ddd; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        header h1 { margin: 0; font-size: 24px; color: #ff4d4f; }
        header h1 a { color: #ff4d4f; text-decoration: none; }
        .container { max-width: 1000px; margin: 40px auto; padding: 0 20px; display: flex; gap: 40px; }
        .item-image { flex: 1; background-color: #e8e8e8; height: 400px; display: flex; justify-content: center; align-items: center; color: #999; font-size: 18px; border-radius: 8px; }
        .item-details { flex: 1; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border: 1px solid #eee; }
        .item-name { font-size: 28px; font-weight: bold; margin: 0 0 10px 0; color: #333; }
        .item-price { font-size: 24px; color: #ff4d4f; font-weight: bold; margin: 0 0 20px 0; border-bottom: 1px solid #eee; padding-bottom: 15px; }
        .section-title { font-size: 16px; font-weight: bold; color: #555; margin-bottom: 8px; margin-top: 20px; }
        .item-description { font-size: 15px; color: #666; line-height: 1.6; background: #f5f5f5; padding: 15px; border-radius: 4px; }
        .btn-back { display: inline-block; margin-top: 30px; color: #1890ff; text-decoration: none; font-size: 14px; }
        .btn-purchase { display: block; width: 100%; text-align: center; background-color: #ff4d4f; color: white; padding: 15px 0; border-radius: 4px; font-size: 18px; font-weight: bold; text-decoration: none; margin-top: 30px; transition: background 0.2s; border: none; box-sizing: border-box; }
        .btn-purchase:hover { background-color: #ff7875; }
        .btn-soldout { display: block; width: 100%; text-align: center; background-color: #ccc; color: #fff; padding: 15px 0; border-radius: 4px; font-size: 18px; font-weight: bold; text-decoration: none; margin-top: 30px; border: none; cursor: not-allowed; box-sizing: border-box; }
    </style>
</head>
<body>

<header>
    <h1><a href="/">フリマアプリ</a></h1>
</header>

<div class="container">
    <div class="item-image">
        {{ $item->name }} 画像
    </div>

    <div class="item-details">
        <h2 class="item-name">{{ $item->name }}</h2>
        <p class="item-price">¥{{ number_format($item->price) }}（税込）</p>

        <p class="section-title">商品説明</p>
        <div class="item-description">
            {!! nl2br(e($item->description)) !!}
        </div>

        @if(isset($item->order_id) && $item->order_id)
            <button class="btn-soldout" disabled>売り切れました</button>
        @else
            <a href="/purchase/{{ $item->id }}" class="btn-purchase">購入手続きへ進む</a>
        @endif
        
        <a href="/" class="btn-back">⬅ 商品一覧に戻る</a>
    </div>
</div>

</body>
</html>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>購入手続き - フリマアプリ</title>
    <style>
        body { font-family: 'Helvetica Neue', Arial, sans-serif; background-color: #f9f9f9; margin: 0; padding: 0; }
        header { background-color: #fff; border-bottom: 1px solid #ddd; padding: 15px 30px; }
        header h1 a { color: #ff4d4f; text-decoration: none; font-size: 24px; font-weight: bold; }
        .container { max-width: 600px; margin: 40px auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border: 1px solid #eee; }
        h2 { border-bottom: 2px solid #ff4d4f; padding-bottom: 10px; margin-top: 0; color: #333; }
        .item-info { display: flex; justify-content: space-between; align-items: center; margin: 30px 0; padding: 20px 0; border-top: 1px solid #eee; border-bottom: 1px solid #eee; }
        .item-name { font-size: 18px; font-weight: bold; }
        .item-price { font-size: 20px; color: #ff4d4f; font-weight: bold; }
        .btn-buy { display: block; width: 100%; text-align: center; background-color: #ff4d4f; color: white; padding: 15px 0; border-radius: 4px; font-size: 18px; font-weight: bold; border: none; cursor: pointer; transition: background 0.2s; }
        .btn-buy:hover { background-color: #ff7875; }
        .shipping-info { background-color: #f5f5f5; padding: 15px; border-radius: 4px; margin-bottom: 30px; font-size: 14px; color: #555; position: relative; }
        .shipping-title { font-weight: bold; margin-bottom: 5px; color: #333; }
        .btn-change-address { position: absolute; top: 15px; right: 15px; color: #1890ff; text-decoration: none; font-size: 13px; font-weight: bold; }
        .btn-soldout { display: block; width: 100%; text-align: center; background-color: #ccc; color: #fff; padding: 15px 0; border-radius: 4px; font-size: 18px; font-weight: bold; border: none; cursor: not-allowed; }
    </style>
</head>
<body>

<header>
    <h1><a href="/">フリマアプリ</a></h1>
</header>

<div class="container">
    <h2>購入内容の確認</h2>
    
    <div class="item-info">
        <span class="item-name">{{ $item->name }}</span>
        <span class="item-price">¥{{ number_format($item->price) }}</span>
    </div>

    <div class="shipping-info">
        <div class="shipping-title">🚚 お届け先住所</div>
        
        <a href="/address/{{ $item->id }}" class="btn-change-address">変更する</a>

        <div>〒{{ session('new_postal_code', '160-0022') }}</div>
        <div>{{ session('new_address', '東京都新宿区新宿5丁目18番21号') }}</div>
        <div>{{ session('new_building', '旧新宿区四谷第五小学校') }}</div>
    </div>

    @if(isset($item->order_id) && $item->order_id)
        <button class="btn-soldout" disabled>
            この商品は売り切れのため購入できません
        </button>
    @else
        <form action="/purchase/{{ $item->id }}" method="POST">
            @csrf
            
            <div style="margin-bottom: 30px;">
                <label for="payment_method" style="display: block; font-weight: bold; margin-bottom: 8px; color: #333;">
                    💳 支払い方法の選択
                </label>
                <select name="payment_method" id="payment_method" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 16px; background-color: #fff; cursor: pointer;">
                    <option value="" disabled selected>選択してください</option>
                    <option value="コンビニ払い">コンビニ払い</option>
                    <option value="カード支払い">カード支払い</option>
                </select>
            </div>

            <input type="hidden" name="postal_code" value="{{ session('new_postal_code', '160-0022') }}">
            <input type="hidden" name="address" value="{{ session('new_address', '東京都新宿区新宿5丁目18番21号') }}">
            <input type="hidden" name="building" value="{{ session('new_building', '旧新宿区四谷第五小学校') }}">
            
            <button type="submit" class="btn-buy">
                購入を確定する
            </button>
        </form>
    @endif
</div>

</body>
</html>
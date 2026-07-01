<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>送付先住所変更 - フリマアプリ</title>
    <style>
        body { font-family: 'Helvetica Neue', Arial, sans-serif; background-color: #f9f9f9; margin: 0; padding: 0; }
        header { background-color: #fff; border-bottom: 1px solid #ddd; padding: 15px 30px; }
        header h1 a { color: #ff4d4f; text-decoration: none; font-size: 24px; font-weight: bold; }
        .container { max-width: 500px; margin: 40px auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border: 1px solid #eee; }
        h2 { border-bottom: 2px solid #ff4d4f; padding-bottom: 10px; margin-top: 0; color: #333; margin-bottom: 20px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 8px; color: #333; font-size: 14px; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 16px; box-sizing: border-box; }
        .btn-update { display: block; width: 100%; text-align: center; background-color: #ff4d4f; color: white; padding: 12px 0; border-radius: 4px; font-size: 16px; font-weight: bold; border: none; cursor: pointer; transition: background 0.2s; }
        .btn-update:hover { background-color: #ff7875; }
        .btn-back { display: block; text-align: center; margin-top: 15px; color: #1890ff; text-decoration: none; font-size: 14px; }
    </style>
</head>
<body>

<header>
    <h1><a href="/">フリマアプリ</a></h1>
</header>

<div class="container">
    <h2>送付先住所変更</h2>
    
    <form action="/address/{{ $id }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="postal_code">郵便番号</label>
            <input type="text" name="postal_code" id="postal_code" required placeholder="例: 123-4567">
        </div>

        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" name="address" id="address" required placeholder="例: 東京都渋谷区道玄坂X-X-X">
        </div>

        <div class="form-group">
            <label for="building">建物名</label>
            <input type="text" name="building" id="building" placeholder="例: ○○マンション101号室">
        </div>

        <button type="submit" class="btn-update">更新する</button>
    </form>

    <a href="/purchase/{{ $id }}" class="btn-back">戻る</a>
</div>

</body>
</html>
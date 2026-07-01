<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>フリマアプリ - 商品一覧</title>
    <style>
        body { font-family: 'Helvetica Neue', Arial, sans-serif; background-color: #f9f9f9; margin: 0; padding: 0; }
        header { background-color: #fff; border-bottom: 1px solid #ddd; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        header h1 { margin: 0; font-size: 24px; color: #ff4d4f; }
        .nav-links a { margin-left: 20px; color: #333; text-decoration: none; font-size: 14px; }
        .container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
        h2 { border-bottom: 2px solid #ff4d4f; padding-bottom: 8px; margin-bottom: 24px; color: #333; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 20px; }
        .card { background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); overflow: hidden; transition: transform 0.2s; border: 1px solid #eee; position: relative; }
        .card:hover { transform: translateY(-4px); }
        .card-img { width: 100%; height: 200px; background-color: #e8e8e8; display: flex; justify-content: center; align-items: center; color: #999; font-size: 14px; }
        .card-content { padding: 15px; }
        .item-name { font-size: 16px; font-weight: bold; margin: 0 0 8px 0; color: #333; word-break: break-all; }
        .item-price { font-size: 18px; color: #ff4d4f; font-weight: bold; margin: 0; }
        
        .sold-label {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: rgba(255, 77, 79, 0.9);
            color: #fff;
            padding: 5px 12px;
            font-weight: bold;
            border-radius: 4px;
            font-size: 12px;
            letter-spacing: 0.5px;
            z-index: 10;
        }
    </style>
</head>
<body>

<header>
    <h1>フリマアプリ</h1>
    <div class="nav-links">
        @auth
            <span>ようこそ、{{ Auth::user()->name }} さん</span>
            <a href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">ログアウト</a>
            <form id="logout-form" action="/logout" method="POST" style="display: none;">@csrf</form>
        @else
            <a href="/login">ログイン</a>
            <a href="/register">会員登録</a>
        @endauth
    </div>
</header>

<div class="container">
    <h2>おすすめ商品一覧</h2>

    <div class="grid">
        @forelse($items as $item)
            <a href="/item/{{ $item->id }}" style="text-decoration: none; color: inherit;">
                <div class="card">
                    
                    @if(isset($item->order_id) && $item->order_id)
                        <div class="sold-label">Sold</div>
                    @endif

                    <div class="card-img">
                        {{ $item->name }} 画像
                    </div>
                    <div class="card-content">
                        <p class="item-name">{{ $item->name }}</p>
                        <p class="item-price">¥{{ number_format($item->price) }}</p>
                    </div>
                </div>
            </a>
        @empty
            <p>商品がありません。</p>
        @endforelse
    </div>
</div>

</body>
</html>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>マイページ - COACHTECH</title>
    <style>
        body { font-family: 'Helvetica Neue', Arial, sans-serif; background-color: #fff; margin: 0; padding: 0; color: #000; }
        
        /* ヘッダーデザイン統一 */
        header { background-color: #000; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; box-sizing: border-box; }
        header h1 { margin: 0; }
        header h1 a { color: #fff; text-decoration: none; font-size: 24px; font-weight: bold; }
        .header-nav { display: flex; align-items: center; gap: 20px; }
        .search-bar { padding: 8px 15px; width: 300px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; font-size: 14px; }
        .nav-link { color: #fff; text-decoration: none; font-size: 14px; font-weight: bold; }
        .btn-sell-nav { background-color: #fff; border: 1px solid #fff; padding: 6px 20px; border-radius: 4px; text-decoration: none; color: #000; font-size: 14px; font-weight: bold; }

        .container { max-width: 1000px; margin: 40px auto; padding: 0 20px; }

        /* ユーザープロフィール表示エリア */
        .profile-section { display: flex; align-items: center; gap: 25px; margin-bottom: 40px; }
        .profile-avatar { width: 80px; height: 80px; background-color: #e5e5e5; border-radius: 50%; border: 1px solid #ccc; }
        .user-name { font-size: 24px; font-weight: bold; margin: 0; }

        /* タブメニュー（出品した商品 / 購入した商品） */
        .tab-menu { display: flex; border-bottom: 1px solid #ccc; margin-bottom: 30px; padding: 0; list-style: none; }
        .tab-item { margin-right: 40px; padding-bottom: 10px; font-size: 16px; font-weight: bold; cursor: pointer; }
        .tab-item a { text-decoration: none; color: #666; }
        .tab-item.active { border-bottom: 2px solid #ff4d4f; }
        .tab-item.active a { color: #ff4d4f; }

        /* 商品グリッド配置 */
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; }
        .card { background: #fff; border-radius: 4px; overflow: hidden; transition: transform 0.2s; border: 1px solid #eee; position: relative; }
        .card:hover { transform: translateY(-3px); }
        .card-img { width: 100%; height: 180px; background-color: #e5e5e5; display: flex; justify-content: center; align-items: center; overflow: hidden; }
        .card-img img { width: 100%; height: 100%; object-fit: cover; }
        .card-content { padding: 12px; }
        .item-name { font-size: 15px; font-weight: bold; margin: 0 0 6px 0; color: #333; word-break: break-all; }
        .item-price { font-size: 16px; color: #000; font-weight: bold; margin: 0; }
        
        .sold-label {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: rgba(255, 77, 79, 0.9);
            color: #fff;
            padding: 4px 10px;
            font-weight: bold;
            border-radius: 4px;
            font-size: 11px;
            z-index: 10;
        }
    </style>
</head>
<body>

<header>
    <h1><a href="/">COACHTECH</a></h1>
    <div class="header-nav">
        <input type="text" class="search-bar" placeholder="なにをお探しですか？">
        @auth
            <a href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">ログアウト</a>
            <a href="/mypage" class="nav-link">マイページ</a>
            <a href="/sell" class="btn-sell-nav">出品</a>
            <form id="logout-form" action="/logout" method="POST" style="display: none;">@csrf</form>
        @else
            <a href="/login" class="nav-link">ログイン</a>
            <a href="/register" class="nav-link">会員登録</a>
        @endauth
    </div>
</header>

<div class="container">
    <div class="profile-section">
        <div class="profile-avatar"></div>
        <h2 class="user-name">{{ $user->name }}</h2>
    </div>

    <ul class="tab-menu">
        <li class="tab-item {{ $tab === 'sell' ? 'active' : '' }}">
            <a href="/mypage?page=sell">出品した商品</a>
        </li>
        <li class="tab-item {{ $tab === 'buy' ? 'active' : '' }}">
            <a href="/mypage?page=buy">購入した商品</a>
        </li>
    </ul>

    <div class="grid">
        @php
            $displayItems = $tab === 'sell' ? $sellItems : $buyItems;
        @endphp

        @forelse($displayItems as $item)
            <a href="/item/{{ $item->id }}" style="text-decoration: none; color: inherit;">
                <div class="card">
                    @if(isset($item->order_id) && $item->order_id)
                        <div class="sold-label">Sold</div>
                    @endif

                    <div class="card-img">
                        @if(!empty($item->img_url))
                            <img src="{{ $item->img_url }}" alt="{{ $item->name }}">
                        @else
                            <span style="color: #999;">No Image</span>
                        @endif
                    </div>
                    
                    <div class="card-content">
                        <p class="item-name">{{ $item->name }}</p>
                        <p class="item-price">¥{{ number_format($item->price) }}</p>
                    </div>
                </div>
            </a>
        @empty
            <p style="color: #666; font-size: 14px;">該当する商品がありません。</p>
        @endforelse
    </div>
</div>

</body>
</html>
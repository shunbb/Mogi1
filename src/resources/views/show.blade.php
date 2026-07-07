<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $item->name }} - 商品詳細</title>
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

        /* レイアウト構成 */
        .container { max-width: 1000px; margin: 40px auto; padding: 0 20px; display: flex; gap: 60px; }
        .left-column { flex: 1.1; }
        .right-column { flex: 0.9; }
        
        /* 商品画像エリア */
        .item-image { width: 100%; height: 500px; background-color: #e5e5e5; display: flex; justify-content: center; align-items: center; overflow: hidden; }
        .item-image img { width: 100%; height: 100%; object-fit: cover; }
        
        /* 商品基本情報 */
        .item-name { font-size: 32px; font-weight: bold; margin: 0 0 5px 0; }
        .brand-name { font-size: 14px; color: #333; margin: 0 0 20px 0; }
        .item-price { font-size: 28px; font-weight: bold; margin: 0 0 15px 0; }
        .price-tax { font-size: 16px; font-weight: normal; margin-left: 5px; }
        
        /* いいね・コメントアイコンエリア */
        .stats-container { display: flex; gap: 25px; margin-bottom: 25px; align-items: center; }
        .stat-item { display: flex; flex-direction: column; align-items: center; font-size: 12px; font-weight: bold; color: #000; text-decoration: none; }
        .stat-icon { font-size: 24px; margin-bottom: 2px; line-height: 1; }

        /* 🌟 いいね送信用ボタンの個別スタイル */
        .btn-like-submit { background: none; border: none; padding: 0; cursor: pointer; display: flex; flex-direction: column; align-items: center; font-size: 12px; font-weight: bold; font-family: inherit; color: #000; }
        .btn-like-submit.liked .stat-icon { color: #ff4d4f; } /* いいね済みの時にハートを赤くする */

        /* 購入ボタン */
        .btn-purchase { display: block; width: 100%; text-align: center; background-color: #ff4d4f; color: white; padding: 12px 0; border-radius: 4px; font-size: 16px; font-weight: bold; text-decoration: none; margin-bottom: 35px; transition: background 0.2s; border: none; box-sizing: border-box; }
        .btn-purchase:hover { background-color: #ff7875; }
        .btn-soldout { display: block; width: 100%; text-align: center; background-color: #ccc; color: #fff; padding: 12px 0; border-radius: 4px; font-size: 16px; font-weight: bold; text-decoration: none; margin-bottom: 35px; border: none; cursor: not-allowed; box-sizing: border-box; }
        
        /* セクションタイトル */
        .section-title { font-size: 20px; font-weight: bold; color: #000; margin: 0 0 15px 0; }
        
        /* 商品説明テキスト */
        .item-description { font-size: 14px; color: #000; line-height: 1.7; white-space: pre-wrap; margin-bottom: 35px; }
        
        /* 商品の情報 */
        .info-row { display: flex; align-items: center; margin-bottom: 15px; font-size: 14px; }
        .info-label { width: 120px; font-weight: bold; color: #000; }
        .info-value { color: #000; }
        
        /* カテゴリータグ */
        .category-tags { display: flex; flex-wrap: wrap; gap: 10px; }
        .category-badge { background-color: #e5e5e5; color: #333; padding: 5px 15px; border-radius: 15px; font-size: 12px; font-weight: normal; }
        
        /* コメント一覧エリア */
        .comment-count { font-size: 16px; font-weight: bold; margin-bottom: 15px; color: #666; }
        .comment-item { display: flex; flex-direction: column; gap: 8px; margin-bottom: 20px; }
        .comment-user { display: flex; align-items: center; gap: 10px; font-weight: bold; font-size: 15px; }
        .user-avatar { width: 32px; height: 32px; background-color: #e5e5e5; border-radius: 50%; }
        .comment-bubble { background-color: #e5e5e5; padding: 12px 15px; border-radius: 4px; font-size: 13px; color: #000; white-space: pre-wrap; word-break: break-all; }
        
        /* コメント入力フォーム */
        .comment-form-title { font-size: 15px; font-weight: bold; margin-bottom: 8px; }
        .comment-textarea { width: 100%; height: 120px; border: 1px solid #767676; padding: 10px; border-radius: 4px; box-sizing: border-box; font-size: 14px; resize: none; margin-bottom: 15px; }
        .btn-comment-submit { display: block; width: 100%; text-align: center; background-color: #ff4d4f; color: white; padding: 12px 0; border-radius: 4px; font-size: 14px; font-weight: bold; border: none; cursor: pointer; transition: background 0.2s; }
        .btn-comment-submit:hover { background-color: #ff7875; }
        .error-message { color: #ff4d4f; font-size: 14px; margin-bottom: 15px; margin-top: -10px; display: block; }
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
    <div class="left-column">
        <div class="item-image">
            @if(!empty($item->img_url))
                <img src="{{ $item->img_url }}" alt="{{ $item->name }}">
            @else
                <span style="color: #999; font-size: 18px;">No Image</span>
            @endif
        </div>
    </div>

    <div class="right-column">
        <h2 class="item-name">{{ $item->name }}</h2>
        <p class="brand-name">{{ $item->brand ?? 'ブランド名' }}</p>
        
        <p class="item-price">¥{{ number_format($item->price) }}<span class="price-tax">（税込）</span></p>

        <div class="stats-container">
            
            <form action="/item/{{ $item->id }}/like" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-like-submit {{ $isLiked ? 'liked' : '' }}">
                    @if($isLiked)
                        <span class="stat-icon">♥</span>
                    @else
                        <span class="stat-icon">♡</span>
                    @endif
                    <span>{{ $likeCount }}</span>
                </button>
            </form>

            <div class="stat-item">
                <span class="stat-icon">💬</span>
                <span>{{ $comments->count() }}</span>
            </div>
        </div>

        @if(isset($item->order_id) && $item->order_id)
            <button class="btn-soldout" disabled>売り切れました</button>
        @else
            <a href="/purchase/{{ $item->id }}" class="btn-purchase">購入手続きへ進む</a>
        @endif

        <h3 class="section-title">商品説明</h3>
        <div class="item-description">{!! nl2br(e($item->description)) !!}</div>

        <h3 class="section-title" style="margin-top: 40px;">商品の情報</h3>
        
        <div class="info-row" style="border-top: 1px solid #ccc; padding-top: 15px;">
            <div class="info-label">カテゴリー</div>
            <div class="info-value">
                <div class="category-tags">
                    @forelse($categories as $category)
                        <span class="category-badge">{{ $category->name }}</span>
                    @empty
                        <span style="color: #999;">指定なし</span>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="info-row" style="border-bottom: 1px solid #ccc; padding-bottom: 15px; margin-bottom: 40px;">
            <div class="info-label">商品の状態</div>
            <div class="info-value">{{ $item->condition }}</div>
        </div>

        <div class="comment-count">コメント ({{ $comments->count() }})</div>
        
        @forelse($comments as $comment)
            <div class="comment-item">
                <div class="comment-user">
                    <div class="user-avatar"></div>
                    <span>{{ $comment->user_name }}</span>
                </div>
                <div class="comment-bubble">{!! nl2br(e($comment->comment)) !!}</div>
            </div>
        @empty
            <p style="color: #999; font-size: 14px; margin-bottom: 30px;">まだコメントはありません。</p>
        @endforelse

        @auth
            <form action="/item/{{ $item->id }}/comment" method="POST" style="margin-top: 30px;">
                @csrf
                <div class="comment-form-title">商品へのコメント</div>
                <textarea name="comment" class="comment-textarea" required placeholder="コメントを入力してください">{{ old('comment') }}</textarea>
                @error('comment')
                    <span class="error-message">コメントは1000文字以内で入力してください。</span>
                @enderror
                <button type="submit" class="btn-comment-submit">コメントを送信する</button>
            </form>
        @else
            <p style="color: #666; font-size: 14px; margin-top: 30px; background: #f5f5f5; padding: 15px; border-radius: 4px;">
                コメントを投稿するには、<a href="/login" style="color: #1890ff; text-decoration: none;">ログイン</a>が必要です。
            </p>
        @endauth
    </div>
</div>

</body>
</html>
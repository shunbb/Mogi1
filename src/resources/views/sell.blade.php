<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品の出品 - フリマアプリ</title>
    <style>
        body { font-family: 'Helvetica Neue', Arial, sans-serif; background-color: #f9f9f9; margin: 0; padding: 0; }
        header { background-color: #fff; border-bottom: 1px solid #ddd; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        header h1 { margin: 0; }
        header h1 a { color: #000; text-decoration: none; font-size: 24px; font-weight: bold; }
        .header-nav { display: flex; align-items: center; gap: 20px; }
        .search-bar { padding: 8px 15px; width: 300px; border: 1px solid #ddd; border-radius: 4px; }
        .nav-link { color: #333; text-decoration: none; font-size: 14px; }
        .btn-sell-nav { background-color: #fff; border: 1px solid #333; padding: 6px 15px; border-radius: 4px; text-decoration: none; color: #333; font-size: 14px; }

        .container { max-width: 600px; margin: 40px auto; background: #fff; padding: 40px; border-radius: 8px; }
        h2 { text-align: center; font-size: 24px; margin-bottom: 30px; color: #333; }
        
        .section-title { border-bottom: 1px solid #ccc; padding-bottom: 8px; margin-top: 40px; margin-bottom: 20px; font-size: 18px; color: #555; }
        
        .form-group { margin-bottom: 25px; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 10px; color: #333; font-size: 14px; }
        
        /* 📸 画像選択エリアのスタイル */
        .image-upload-zone { border: 2px dashed #ccc; padding: 40px; text-align: center; background-color: #fafafa; border-radius: 4px; cursor: pointer; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 15px; }
        .btn-select-image { background: #fff; border: 1px solid #ff4d4f; color: #ff4d4f; padding: 8px 16px; border-radius: 4px; font-size: 12px; cursor: pointer; font-weight: bold; }
        
        /* プレビュー画像のスタイル設定 */
        #preview { max-width: 100%; max-height: 180px; border-radius: 4px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); display: none; }

        .category-container { display: flex; flex-wrap: wrap; gap: 10px; }
        .category-tag { position: relative; }
        .category-tag input[type="checkbox"] { position: absolute; opacity: 0; cursor: pointer; height: 0; width: 0; }
        .category-label { display: inline-block; padding: 6px 14px; border: 1px solid #ff4d4f; color: #ff4d4f; border-radius: 20px; font-size: 12px; cursor: pointer; transition: all 0.2s; background-color: #fff; }
        .category-tag input[type="checkbox"]:checked + .category-label { background-color: #ff4d4f; color: #fff; }
        .form-group input[type="text"], .form-group input[type="number"], .form-group textarea, .form-group select { width: 100%; padding: 12px; border: 1px solid #bbb; border-radius: 4px; font-size: 16px; box-sizing: border-box; background-color: #fff; }
        .form-group textarea { height: 120px; resize: vertical; }
        .btn-submit { display: block; width: 100%; text-align: center; background-color: #ff4d4f; color: white; padding: 15px 0; border-radius: 4px; font-size: 18px; font-weight: bold; border: none; cursor: pointer; transition: background 0.2s; margin-top: 40px; }
        .btn-submit:hover { background-color: #ff7875; }
    </style>
</head>
<body>

<header>
    <h1><a href="/">COACHTECH</a></h1>
    <div class="header-nav">
        <input type="text" class="search-bar" placeholder="なにをお探しですか？">
        <a href="#" class="nav-link">ログアウト</a>
        <a href="#" class="nav-link">マイページ</a>
        <a href="/sell" class="btn-sell-nav">出品</a>
    </div>
</header>

<div class="container">
    <h2>商品の出品</h2>
    
    <form action="/sell" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>商品画像</label>
            <div class="image-upload-zone" onclick="document.getElementById('image').click()">
                <img id="preview" src="" alt="プレビュー">
                <button type="button" class="btn-select-image" id="select-btn">画像を選択する</button>
                <input type="file" name="image" id="image" accept="image/*" required style="display: none;">
            </div>
        </div>

        <div class="section-title">商品の詳細</div>

        <div class="form-group">
            <label>カテゴリー</label>
            <div class="category-container">
                @php
                    $categories = ['ファッション', '家電', 'インテリア', 'レディース', 'メンズ', 'コスメ', '本', 'ゲーム', 'スポーツ', 'キッチン', 'ハンドメイド', 'アクセサリー', 'おもちゃ', 'ベビー・キッズ'];
                @endphp
                
                @foreach($categories as $category)
                    <div class="category-tag">
                        <input type="checkbox" name="category[]" value="{{ $category }}" id="cat_{{ $loop->index }}">
                        <label for="cat_{{ $loop->index }}" class="category-label">{{ $category }}</label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="form-group">
            <label for="condition">商品の状態</label>
            <select name="condition" id="condition" required>
                <option value="" disabled selected>選択してください</option>
                <option value="新品、未使用">新品、未使用</option>
                <option value="未使用に近い">未使用に近い</option>
                <option value="目立った傷や汚れなし">目立った傷や汚れなし</option>
                <option value="やや傷や汚れあり">やや傷や汚れあり</option>
                <option value="傷や汚れあり">傷や汚れあり</option>
            </select>
        </div>

        <div class="section-title">商品名と説明</div>

        <div class="form-group">
            <label for="name">商品名</label>
            <input type="text" name="name" id="name" required>
        </div>

        <div class="form-group">
            <label for="brand">ブランド名</label>
            <input type="text" name="brand" id="brand">
        </div>

        <div class="form-group">
            <label for="description">商品の説明</label>
            <textarea name="description" id="description" required></textarea>
        </div>

        <div class="form-group">
            <label for="price">販売価格</label>
            <input type="number" name="price" id="price" required min="300" max="9999999" placeholder="¥">
        </div>

        <button type="submit" class="btn-submit">出品する</button>
    </form>
</div>

<script>
    document.getElementById('image').addEventListener('change', function(e) {
        const reader = new FileReader();
        const preview = document.getElementById('preview');
        const btn = document.getElementById('select-btn');
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block'; // 画像を表示する
            btn.textContent = '画像を変更する'; // ボタンのテキストを変更
        }
        
        if (e.target.files[0]) {
            reader.readAsDataURL(e.target.files[0]);
        }
    });
</script>

</body>
</html>
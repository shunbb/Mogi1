<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>購入手続き - {{ $item->name }}</title>
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

        .container { max-width: 1000px; margin: 40px auto; padding: 0 20px; display: flex; gap: 60px; }
        .left-column { flex: 1.2; }
        .right-column { flex: 0.8; border: 1px solid #000; padding: 30px; border-radius: 4px; height: fit-content; }

        /* 商品情報セクション */
        .item-info-section { display: flex; gap: 20px; align-items: center; border-bottom: 1px solid #ccc; padding-bottom: 30px; margin-bottom: 30px; }
        .item-image { width: 120px; height: 120px; background-color: #e5e5e5; display: flex; justify-content: center; align-items: center; border-radius: 4px; overflow: hidden; }
        .item-image img { width: 100%; height: 100%; object-fit: cover; }
        .item-meta h2 { margin: 0 0 10px 0; font-size: 24px; }
        .item-price { font-size: 20px; font-weight: bold; margin: 0; }

        /* フォーム要素 */
        .form-group { border-bottom: 1px solid #ccc; padding-bottom: 30px; margin-bottom: 30px; }
        .form-title-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }
        .form-label { font-size: 16px; font-weight: bold; }
        .btn-change-address { color: #1890ff; text-decoration: none; font-size: 14px; }
        
        .select-payment { width: 100%; padding: 10px; border: 1px solid #767676; border-radius: 4px; font-size: 15px; }
        .address-display { font-size: 15px; line-height: 1.6; color: #333; }

        /* 右側：確認確認エリア */
        .summary-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .summary-table td { padding: 12px 0; font-size: 16px; }
        .summary-table .price-val { text-align: right; font-weight: bold; }
        .summary-table .total-row { font-weight: bold; font-size: 18px; border-top: 1px solid #ccc; }

        .btn-submit-purchase { display: block; width: 100%; background-color: #ff4d4f; color: white; padding: 12px 0; border-radius: 4px; font-size: 16px; font-weight: bold; border: none; cursor: pointer; text-align: center; transition: background 0.2s; }
        .btn-submit-purchase:hover { background-color: #ff7875; }
        
        .error-message { color: #ff4d4f; font-size: 14px; margin-top: 5px; }
    </style>
</head>
<body>

<header>
    <h1><a href="/">COACHTECH</a></h1>
    <div class="header-nav">
        <input type="text" class="search-bar" placeholder="なにをお探しですか？">
        @auth
            <a href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">ログアウト</a>
            <a href="#" class="nav-link">マイページ</a>
            <a href="/sell" class="btn-sell-nav">出品</a>
            <form id="logout-form" action="/logout" method="POST" style="display: none;">@csrf</form>
        @else
            <a href="/login" class="nav-link">ログイン</a>
            <a href="/register" class="nav-link">会員登録</a>
        @endauth
    </div>
</header>

<div class="container">
    <form action="/purchase/{{ $item->id }}" method="POST" style="display: flex; width: 100%; gap: 60px;">
        @csrf

        <div class="left-column">
            
            <div class="item-info-section">
                <div class="item-image">
                    @if(!empty($item->img_url))
                        <img src="{{ $item->img_url }}" alt="{{ $item->name }}">
                    @else
                        <span style="color: #999; font-size: 14px;">No Image</span>
                    @endif
                </div>
                <div class="item-meta">
                    <h2>{{ $item->name }}</h2>
                    <p class="item-price">¥{{ number_format($item->price) }}</p>
                </div>
            </div>

            <div class="form-group">
                <div class="form-title-row">
                    <label class="form-label" for="payment_method">支払い方法</label>
                </div>
                <select name="payment_method" id="payment_method" class="select-payment">
                    <option value="">選択してください</option>
                    <option value="コンビニ払い" {{ old('payment_method') == 'コンビニ払い' ? 'selected' : '' }}>コンビニ払い</option>
                    <option value="カード決済" {{ old('payment_method') == 'カード決済' ? 'selected' : '' }}>カード決済</option>
                </select>
                @error('payment_method')
                    <div class="error-message">支払い方法を選択してください。</div>
                @enderror
            </div>

            <div class="form-group">
                <div class="form-title-row">
                    <span class="form-label">配送先</span>
                    <a href="/address/{{ $item->id }}" class="btn-change-address">変更する</a>
                </div>
                <div class="address-display">
                    <input type="hidden" name="postal_code" value="{{ session('new_postal_code', '123-4567') }}">
                    <input type="hidden" name="address" value="{{ session('new_address', '東京都渋谷区道玄坂X-X-X') }}">
                    <input type="hidden" name="building" value="{{ session('new_building', 'ココーチテックビル') }}">

                    〒{{ session('new_postal_code', '160-0022') }}<br>
                    {{ session('new_address', '東京都新宿区新宿5丁目18番21号') }}<br>
                    {{ session('new_building', '旧新宿区四谷第五小学校') }}
                </div>
                @error('postal_code') <div class="error-message">配送先情報が不足しています。</div> @enderror
                @error('address') <div class="error-message">配送先情報が不足しています。</div> @enderror
            </div>

        </div>

        <div class="right-column">
            <table class="summary-table">
                <tr>
                    <td>商品代金</td>
                    <td class="price-val">¥{{ number_format($item->price) }}</td>
                </tr>
                <tr class="total-row">
                    <td>支払い金額</td>
                    <td class="price-val" style="padding-top: 15px;">¥{{ number_format($item->price) }}</td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size: 14px; padding-top: 20px; color: #555;">支払い方法</td>
                </tr>
                <tr>
                    <td id="selected-payment-display" colspan="2" style="font-size: 15px; font-weight: bold; padding-top: 0;">
                        未選択
                    </td>
                </tr>
            </table>

            <button type="submit" class="btn-submit-purchase">購入する</button>
        </div>
    </form>
</div>

<script>
    const paymentSelect = document.getElementById('payment_method');
    const paymentDisplay = document.getElementById('selected-payment-display');

    function updatePaymentDisplay() {
        paymentDisplay.textContent = paymentSelect.value || '未選択';
    }

    paymentSelect.addEventListener('change', updatePaymentDisplay);
    updatePaymentDisplay();
</script>

</body>
</html>
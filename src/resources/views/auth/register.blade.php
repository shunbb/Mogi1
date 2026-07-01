<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会員登録 - フリマアプリ</title>
    <style>
        body { font-family: 'Helvetica Neue', Arial, sans-serif; background-color: #f9f9f9; margin: 0; padding: 0; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .auth-container { background: #fff; padding: 40px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        h2 { text-align: center; margin-bottom: 24px; color: #333; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; color: #555; font-weight: bold; }
        input[type="text"], input[type="email"], input[type="password"] { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; font-size: 14px; }
        .btn-submit { width: 100%; padding: 12px; background-color: #ff4d4f; border: none; border-radius: 4px; color: white; font-size: 16px; font-weight: bold; cursor: pointer; transition: background 0.2s; }
        .btn-submit:hover { background-color: #ff7875; }
        .error-list { color: #ff4d4f; margin-bottom: 20px; font-size: 14px; padding-left: 20px; }
        .links { text-align: center; margin-top: 20px; font-size: 14px; }
        .links a { color: #1890ff; text-decoration: none; }
    </style>
</head>
<body>

<div class="auth-container">
    <h2>会員登録</h2>

    @if ($errors->any())
        <ul class="error-list">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="/register" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">ユーザー名</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label for="password">パスワード</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group">
            <label for="password_confirmation">パスワード（確認用）</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>

        <button type="submit" class="btn-submit">登録する</button>
    </form>

    <div class="links">
        <a href="/login">すでにアカウントをお持ちの方（ログイン）</a>
    </div>
</div>

</body>
</html>
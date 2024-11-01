<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="login-container">
        <h2>Đăng nhập</h2>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <label for="email">Email:</label>
            <input type="email" name="email" required>
            
            <label for="password">Mật khẩu:</label>
            <input type="password" name="password" required>

            <button type="submit">Đăng nhập</button>
        </form>
    </div>
</body>
</html>

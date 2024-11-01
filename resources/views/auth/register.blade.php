<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>
    <div class="register-container">
        <h2>Đăng ký tài khoản</h2>
        <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="content">
                <label for="name">Tên:</label><br>
                <input type="text" name="name" required>
            </div>
            <div class="content">
                <label for="birth_date">Ngày sinh:</label><br>
                <input type="date" name="birth_date" required>
            </div>
            <div class="content">
                <label for="hometown">Quê quán:</label><br>
                <input type="text" name="hometown" required>
            </div>
            <div class="content">
                <label for="role">Vai trò:</label>
                <select name="role" required>
                    <option value="author">Tác giả</option>
                    <option value="reader">Độc giả</option>
                </select>
            </div>
            <div class="content">
                <label for="avatar">Ảnh đại diện:</label><br>
                <input type="file" name="avatar" accept="image/*">
            </div>
            <div class="content">
                <label for="email">Email:</label><br>
                <input type="email" name="email" required>
            </div>
            <div class="content">
                <label for="password">Mật khẩu:</label><br>
                <input type="password" name="password" required>
            </div>
            <div class="content">
                <label for="password_confirmation">Xác nhận mật khẩu:</label><br>
                <input type="password" name="password_confirmation" required>
            </div>
            <div class="content">
                <button type="submit">Đăng ký</button>
            </div>
        </form>
        
    </div>
</body>
</html>

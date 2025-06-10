<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #43cea2 0%, #185a9d 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .register-container {
            background: rgba(255,255,255,0.97);
            padding: 2.5rem 2rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            width: 100%;
            max-width: 480px;
        }
        .register-title {
            color: #185a9d;
            margin-bottom: 2rem;
            text-align: center;
            font-size: 2rem;
            font-weight: 600;
        }
        .form-label {
            font-weight: 500;
            color: #185a9d;
        }
        .form-control, .form-select {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            border: 2px solid #e2e8f0;
            transition: all 0.3s;
        }
        .form-control:focus, .form-select:focus {
            border-color: #43cea2;
            box-shadow: 0 0 0 3px rgba(67,206,162,0.1);
        }
        .btn-register {
            width: 100%;
            padding: 0.8rem;
            font-weight: 600;
            border-radius: 8px;
            background: linear-gradient(to right, #43cea2, #185a9d);
            border: none;
            color: #fff;
            transition: all 0.3s;
        }
        .btn-register:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(67,206,162,0.15);
        }
        .mb-3 {
            margin-bottom: 1.2rem !important;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2 class="register-title">Đăng ký tài khoản</h2>
        <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Họ và tên</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="Nhập tên của bạn">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="birth_date" class="form-label">Ngày sinh</label>
                <input type="date" class="form-control" id="birth_date" name="birth_date" required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Vai trò</label>
                <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                    <option value="">Chọn vai trò</option>
                    <option value="reader" {{ old('role') == 'reader' ? 'selected' : '' }}>Độc giả</option>
                    <option value="author" {{ old('role') == 'author' ? 'selected' : '' }}>Tác giả</option>
                </select>
                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="avatar" class="form-label">Ảnh đại diện</label>
                <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required placeholder="Nhập email">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required placeholder="Nhập mật khẩu">
                <div class="form-text">Mật khẩu phải có ít nhất 8 ký tự, bao gồm chữ hoa, chữ thường và số</div>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="Nhập lại mật khẩu">
            </div>
            <button type="submit" class="btn btn-register">Đăng ký</button>
        </form>
    </div>
</body>
</html>

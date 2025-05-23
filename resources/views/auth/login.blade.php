<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 420px;
            backdrop-filter: blur(10px);
        }
        .login-title {
            color: #2d3748;
            margin-bottom: 2rem;
            text-align: center;
            font-size: 2rem;
            font-weight: 600;
        }
        .form-label {
            font-weight: 500;
            color: #4a5568;
            margin-bottom: 0.5rem;
        }
        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102,126,234,0.1);
        }
        .btn-login {
            width: 100%;
            padding: 0.8rem;
            font-weight: 600;
            border-radius: 8px;
            background: linear-gradient(to right, #667eea, #764ba2);
            border: none;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(102,126,234,0.2);
        }
        .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
        }
        .form-check-label {
            color: #4a5568;
        }
        .input-group {
            position: relative;
        }
        .input-group .form-control {
            padding-left: 2.5rem;
        }
        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
        }
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.5rem 0;
            color: #718096;
        }
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e2e8f0;
        }
        .divider span {
            padding: 0 1rem;
        }
        .social-login {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }
        .social-btn {
            flex: 1;
            padding: 0.75rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            background: white;
            color: #4a5568;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .social-btn:hover {
            background: #f7fafc;
            border-color: #cbd5e0;
        }
        .register-section {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e2e8f0;
        }
        .register-text {
            color: #4a5568;
            margin-bottom: 0.5rem;
        }
        .btn-register {
            display: inline-block;
            padding: 0.5rem 1.5rem;
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-register:hover {
            color: #764ba2;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 class="login-title">Chào mừng trở lại!</h2>
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="email" class="form-label">Email</label>
                <div class="input-group">
                    <i class="input-icon fas fa-envelope"></i>
                    <input type="email" class="form-control" id="email" name="email" required 
                           placeholder="Nhập email của bạn">
                </div>
            </div>
            
            <div class="mb-4">
                <label for="password" class="form-label">Mật khẩu</label>
                <div class="input-group">
                    <i class="input-icon fas fa-lock"></i>
                    <input type="password" class="form-control" id="password" name="password" required
                           placeholder="Nhập mật khẩu của bạn">
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-login">Đăng nhập</button>
        </form>

        <div class="register-section">
            <p class="register-text">Chưa có tài khoản?</p>
            <a href="{{ route('register') }}" class="btn-register">
                <i class="fas fa-user-plus me-2"></i>Đăng ký ngay
            </a>
        </div>
    </div>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</body>
</html>

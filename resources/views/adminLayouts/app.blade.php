<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin blog</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --sidebar-width: 250px;
            --primary-color: #4e73df;
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --sidebar-bg: #4e73df;
            --sidebar-text: #fff;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fc;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--sidebar-bg) 0%, #224abe 100%);
            color: var(--sidebar-text);
            padding: 1rem;
            transition: all 0.3s;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-header h3 {
            color: white;
            font-size: 1.2rem;
            margin: 0;
            font-weight: 600;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 1rem 0;
        }

        .sidebar-menu li {
            margin-bottom: 0.5rem;
        }

        .sidebar-menu a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            padding: 0.8rem 1rem;
            display: flex;
            align-items: center;
            border-radius: 0.35rem;
            transition: all 0.3s;
        }

        .sidebar-menu a:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }

        .sidebar-menu a i {
            margin-right: 0.75rem;
            width: 20px;
            text-align: center;
        }

        .sidebar-menu a.active {
            background: rgba(255,255,255,0.1);
            color: white;
        }

        .logout-section {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1rem;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        .logout-btn {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            padding: 0.8rem 1rem;
            display: flex;
            align-items: center;
            border-radius: 0.35rem;
            transition: all 0.3s;
        }

        .logout-btn:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 1.5rem;
            min-height: 100vh;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h3><i class="fas fa-newspaper me-2"></i>Quản lý</h3>
        </div>
        
        <ul class="sidebar-menu">
            @if(auth()->user()->role == 'admin')
                <li>
                    <a href="{{ route('author.index') }}">
                        <i class="fas fa-users"></i>
                        Quản lý tác giả
                    </a>
                </li>
                <li>
                    <a href="{{ route('adminIndex') }}">
                        <i class="fas fa-file-alt"></i>
                        Quản lý bài viết
                    </a>
                </li>
                <li>
                    <a href="{{ route('waitingApproval') }}">
                        <i class="fas fa-clock"></i>
                        Chờ duyệt
                    </a>
                </li>
                <li>
                    <a href="{{ route('categories') }}">
                        <i class="fas fa-tags"></i>
                        Quản lý danh mục
                    </a>
                </li>
            @elseif(auth()->user()->role == 'author')
                <li>
                    <a href="{{ route('posts.create') }}">
                        <i class="fas fa-plus-circle"></i>
                        Tạo bài viết
                    </a>
                </li>
                <li>
                    <a href="{{ route('listOfPostByAuthor', auth()->user()->id) }}">
                        <i class="fas fa-list"></i>
                        Quản lý bài viết
                    </a>
                </li>
            @endif
        </ul>

        <div class="logout-section">
            <a href="{{ route('logout') }}" class="logout-btn">
                <i class="fas fa-sign-out-alt me-2"></i>
                Đăng xuất
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @yield('content')
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

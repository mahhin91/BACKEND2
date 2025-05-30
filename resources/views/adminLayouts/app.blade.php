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

        .sidebar .nav-link {
            color: #333;
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .sidebar .nav-link:hover {
            background-color: #f8f9fa;
        }

        .sidebar .nav-link.active {
            background-color: #e9ecef;
            color: #0d6efd;
        }

        .sidebar .nav-link i {
            margin-right: 0.5rem;
            width: 20px;
            text-align: center;
        }

        .sidebar .nav-link .ms-auto {
            margin-left: auto;
        }

        .sidebar .collapse .nav-link {
            padding-left: 2.5rem;
        }

        .sidebar .collapse .nav-link i {
            font-size: 0.875rem;
        }

        /* Dropdown menu styles */
        .sidebar-submenu {
            list-style: none;
            padding-left: 2.5rem;
            margin: 0;
            display: none;
        }

        .sidebar-submenu.show {
            display: block;
        }

        .sidebar-submenu li a {
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            font-size: 0.9rem;
            border-radius: 0.35rem;
            transition: all 0.3s;
        }

        .sidebar-submenu li a:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }

        .sidebar-submenu li a.active {
            background: rgba(255,255,255,0.1);
            color: white;
        }

        .sidebar-submenu li a i {
            margin-right: 0.5rem;
            width: 20px;
            text-align: center;
        }

        .sidebar-menu-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .sidebar-menu-item .ms-auto {
            margin-left: auto;
            transition: transform 0.3s;
        }

        .sidebar-menu-item[aria-expanded="true"] .ms-auto {
            transform: rotate(180deg);
        }

        /* Thêm style cho mũi tên */
        .sidebar-menu-item .fa-chevron-down {
            transition: transform 0.3s ease;
        }

        .sidebar-menu-item[aria-expanded="true"] .fa-chevron-down {
            transform: rotate(180deg);
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
                    <a href="{{ route('admin.authors.index') }}">
                        <i class="fas fa-users"></i>
                        Quản lý tác giả
                    </a>
                </li>
                <li>
                    <a href="#postSubmenu" data-bs-toggle="collapse" class="sidebar-menu-item {{ request('status') ? 'active' : '' }}" 
                       aria-expanded="{{ request('status') ? 'true' : 'false' }}">
                        <i class="fas fa-file-alt"></i>
                        Quản lý bài viết
                        <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <ul class="sidebar-submenu {{ request('status') ? 'show' : '' }}" id="postSubmenu">
                        <li>
                            <a href="{{ route('admin.posts.index', ['status' => 'pending']) }}" class="{{ request('status') == 'pending' ? 'active' : '' }}">
                                <i class="fas fa-clock"></i>
                                Đang chờ duyệt
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.posts.index', ['status' => 'approved']) }}" class="{{ request('status') == 'approved' ? 'active' : '' }}">
                                <i class="fas fa-check-circle"></i>
                                Đã xác nhận
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.posts.index', ['status' => 'rejected']) }}" class="{{ request('status') == 'rejected' ? 'active' : '' }}">
                                <i class="fas fa-times-circle"></i>
                                Đã từ chối
                            </a>
                        </li>
                    </ul>
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
    
    <!-- Thêm script này -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Lấy tất cả các dropdown toggle
            const dropdownToggles = document.querySelectorAll('[data-bs-toggle="collapse"]');
            
            dropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Lấy target của dropdown
                    const target = document.querySelector(this.getAttribute('href'));
                    
                    // Toggle class show
                    target.classList.toggle('show');
                    
                    // Toggle aria-expanded
                    this.setAttribute('aria-expanded', 
                        this.getAttribute('aria-expanded') === 'true' ? 'false' : 'true'
                    );
                });
            });

            // Tự động mở dropdown nếu có status trong URL
            if (window.location.search.includes('status=')) {
                const postSubmenu = document.getElementById('postSubmenu');
                const postToggle = document.querySelector('[href="#postSubmenu"]');
                if (postSubmenu && postToggle) {
                    postSubmenu.classList.add('show');
                    postToggle.setAttribute('aria-expanded', 'true');
                }
            }
        });
    </script>
</body>
</html>

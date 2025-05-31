<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="fas fa-newspaper me-2"></i>News Portal
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="fas fa-home me-1"></i> Trang Chủ
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('posts') ? 'active' : '' }}" href="{{ route('posts') }}">
                        <i class="fas fa-newspaper me-1"></i> Bài Viết
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="categoriesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-tags me-1"></i> Danh Mục
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="categoriesDropdown">
                        @foreach($categories as $category)
                            <li>
                                <a class="dropdown-item {{ request('category') == $category->id ? 'active' : '' }}" 
                                   href="{{ route('home', ['category' => $category->id]) }}">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            @if(auth()->user()->role == 'admin')
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.posts.index') }}">
                                        <i class="fas fa-newspaper"></i> Quản lý bài viết
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.authors.index') }}">
                                        <i class="fas fa-users"></i> Quản lý tác giả
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.posts.waiting') }}">
                                        <i class="fas fa-clock"></i> Bài viết chờ duyệt
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('categories') }}">
                                        <i class="fas fa-tags"></i> Quản lý danh mục
                                    </a>
                                </li>
                            @elseif(Auth::user()->role === 'author')
                                <li>
                                    <a class="dropdown-item" href="{{ route('posts.create') }}">
                                        <i class="fas fa-plus-circle me-2"></i> Tạo bài viết
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('author.posts.list', auth()->user()->id) }}">
                                        <i class="fas fa-list me-2"></i> Quản lý bài viết
                                    </a>
                                </li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i> Đăng Xuất
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i> Đăng Nhập
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">
                            <i class="fas fa-user-plus me-1"></i> Đăng Ký
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

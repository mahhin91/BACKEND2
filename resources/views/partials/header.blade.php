<div class="header">
    <nav>
        <ul>
            <li><a class="page" href="{{ route('home') }}">Trang Chủ</a></li>
            <li><a class="page" href="{{ route('posts') }}">Bài Viết</a></li>
            <li class="dropdown">
                <a class="page" href="#" class="dropbtn">Danh Mục</a>
                <div class="dropdown-content">
                    @foreach($categories as $category)
                        <a class="page-content" href="{{ route('home', ['category' => $category->id]) }}">{{ $category->name }}</a>
                    @endforeach
                </div>
            </li>
            <li class="dropdown">
                <a class="page" href="#" class="dropbtn">Menu</a>
                <div class="dropdown-content">
                    @auth
                        <a class="page-content" href="#">Chào mừng, {{ Auth::user()->name }}</a>
                        <a class="page-content" href="{{ route('logout') }}">Đăng Xuất</a>
                    @else
                        <a class="page-content" href="{{ route('login') }}">Đăng Nhập</a>
                        <a class="page-content" href="{{ route('register') }}">Đăng Ký</a>
                    @endauth
                </div>
            </li>
        </ul>
    </nav>
</div>

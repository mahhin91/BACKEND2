<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý bài viết</title>
    <link rel="stylesheet" href="{{ asset('css/adminLayout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/post/create.css') }}">
    <link rel="stylesheet" href="{{ asset('css/post/index.css') }}">
</head>
<body>
    <div class="sidebar">
        <h3>Trang web quan ly posts</h3>
        <ul>
            @if(auth()->user()->role == 'admin')
                <li><a href="{{ route('author.index') }}">Quản lý tác giả</a></li>
                <li><a href="{{ route('adminIndex') }}">Quản lý bài viết</a></li>
                <li>
                    <a href="{{ route('waitingApproval') }}">Chờ duyệt</a>
                </li>
                <li><a href="{{ route('categories') }}">Quản lý danh mục</a></li>
                
            @elseif(auth()->user()->role == 'author')
                <li><a href="{{ route('posts.create') }}">Tạo bài viết</a></li>
                <li><a href="{{ route('listOfPostByAuthor', auth()->user()->id) }}">Quản lý bài viết</a></li>
            @endif
        </ul>
        <div class="logout">
            <a href="{{ route('logout') }}">Đăng xuất</a>
        </div>
    </div>
    <div class="content">
        @yield('content')
    </div>
</body>
</html>

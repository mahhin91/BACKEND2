<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/postDetail.css') }}">
</head>
<body>
    @include('partials.header')
    <div class="content">
        @yield('content')
    </div>
    {{-- <script src="{{ asset('js/script.js') }}"></script> --}}
</body>
</html>
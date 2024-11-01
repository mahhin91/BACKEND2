@extends('layouts.app')

@section('content')
<div class="posts-container">
    <h2>Danh Sách Bài Viết</h2>
    <div class="posts">
        @foreach($posts as $post)
            <div class="post-card">
                <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="Thumbnail">
                <h3>{{ $post->title }}</h3>
                <p>Người tạo: {{ $post->user->name }}</p>
                <p>Ngày đăng: {{ $post->published_at->format('d/m/Y') }}</p>
                <p>{{ \Illuminate\Support\Str::limit($post->content, 100) }}</p>
                <a href="{{ route('posts.show', $post->id) }}">Đọc thêm</a>
            </div>
        @endforeach
    </div>

    <!-- Phân trang -->
    <div class="pagination">
        {{ $posts->links() }}
    </div>
</div>
@endsection

@php
 use Carbon\Carbon;   
@endphp

@extends('layouts.app')

@section('content')
<div class="posts-container">
    <h2 class="title-page">Danh Sách Bài Viết</h2>
    <div class="posts">
        @foreach($posts as $post)
            <div class="post-card">
                <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="Thumbnail">
                <h3>{{ $post->title }}</h3>
                <p class="author-card tal">Người tạo: {{ $post->user->name }}</p>
                <p class="created_at-card tal">Ngày đăng: {{ \Carbon\Carbon::parse($post->published_at)->format('d/m/Y') }}</p>
                <p class="tal content-post">{{ \Illuminate\Support\Str::limit($post->content, 100) }}</p>
                <a class="detail-post" href="{{ route('detailPost', $post->id) }}">Đọc thêm</a>
                <div class="likes">
                    <p>like:{{ $post->likes }}</p>
                    <p>like:{{ $post->dislikes }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Phân trang -->
    <div class="pagination">
        {{ $posts->links() }}
    </div>
</div>
@endsection

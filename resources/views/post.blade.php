@php
 use Carbon\Carbon;   
@endphp

@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center title-page">Danh Sách Bài Viết</h2>
    <div class="row g-4">
        @foreach($posts as $post)
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('storage/' . $post->thumbnail) }}" class="card-img-top" alt="Thumbnail" style="height: 200px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <p class="mb-1 text-muted"><i class="fas fa-user"></i> Người tạo: {{ $post->user->name }}</p>
                        <p class="mb-1 text-muted"><i class="fas fa-calendar-alt"></i> Ngày đăng: {{ Carbon::parse($post->published_at)->format('d/m/Y') }}</p>
                        <p class="card-text flex-grow-1">{{ \Illuminate\Support\Str::limit($post->content, 100) }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <a class="btn btn-sm btn-primary" href="{{ route('detailPost', $post->id) }}">
                                <i class="fas fa-book-open"></i> Đọc thêm
                            </a>
                            <div>
                                <span class="badge bg-success me-1"><i class="fas fa-thumbs-up"></i> {{ $post->likes }}</span>
                                <span class="badge bg-danger"><i class="fas fa-thumbs-down"></i> {{ $post->dislikes }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Phân trang -->
    <div class="d-flex justify-content-center mt-4">
        {{ $posts->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection

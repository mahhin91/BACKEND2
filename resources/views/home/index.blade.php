@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- Bài viết nổi bật --}}
    <h2 class="mb-4 text-center text-warning"><i class="fas fa-star"></i> Bài Viết Nổi Bật</h2>
    <div class="row g-4 mb-5">
        @foreach($featuredPosts as $post)
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 border-warning shadow-sm">
                    <img src="{{ asset('storage/' . $post->thumbnail) }}" class="card-img-top" alt="Thumbnail" style="height: 180px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-warning">{{ $post->title }}</h5>
                        <p class="mb-1 text-muted"><i class="fas fa-user"></i> {{ $post->user->name }}</p>
                        <p class="mb-1 text-muted"><i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($post->published_at)->format('d/m/Y') }}</p>
                        <p class="mb-1 text-muted"><i class="fas fa-eye"></i> Lượt xem: {{ number_format($post->views) }}</p>
                        <p class="card-text flex-grow-1">{{ \Illuminate\Support\Str::limit($post->content, 80) }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <a class="btn btn-sm btn-outline-warning" href="{{ route('detailPost', $post->id) }}">
                                <i class="fas fa-book-open"></i> Đọc thêm
                            </a>
                            <div>
                                <span class="badge bg-warning text-dark me-1"><i class="fas fa-thumbs-up"></i> {{ $post->likes() }}</span>
                                <span class="badge bg-danger"><i class="fas fa-thumbs-down"></i> {{ $post->dislikes() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Bài viết mới nhất --}}
    <h2 class="mb-4 text-center text-primary"><i class="fas fa-clock"></i> Bài Viết Mới Nhất</h2>
    <div class="row g-4">
        @foreach($posts as $post)
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-primary shadow-sm">
                    <img src="{{ asset('storage/' . $post->thumbnail) }}" class="card-img-top" alt="Thumbnail" style="height: 200px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-primary">{{ $post->title }}</h5>
                        <p class="mb-1 text-muted"><i class="fas fa-user"></i> {{ $post->user->name }}</p>
                        <p class="mb-1 text-muted"><i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($post->published_at)->format('d/m/Y') }}</p>
                        <p class="mb-1 text-muted"><i class="fas fa-eye"></i> Lượt xem: {{ number_format($post->views) }}</p>
                        <p class="card-text flex-grow-1">{{ \Illuminate\Support\Str::limit($post->content, 100) }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('detailPost', $post->id) }}">
                                <i class="fas fa-book-open"></i> Đọc thêm
                            </a>
                            <div>
                                <span class="badge bg-primary me-1"><i class="fas fa-thumbs-up"></i> {{ $post->likes() }}</span>
                                <span class="badge bg-danger"><i class="fas fa-thumbs-down"></i> {{ $post->dislikes() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@push('styles')
<style>
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .card-title {
        font-weight: 600;
        margin-bottom: 1rem;
    }
    .card-text {
        color: #666;
        font-size: 0.95rem;
    }
    .badge {
        font-size: 0.85rem;
        padding: 0.5em 0.8em;
    }
    .btn-sm {
        padding: 0.4rem 0.8rem;
        font-size: 0.9rem;
    }
</style>
@endpush
@endsection

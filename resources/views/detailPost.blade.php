@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            {{-- Nút quay lại --}}
            <div class="mb-4">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Quay lại
                </a>
            </div>

            {{-- Bài viết chính --}}
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    {{-- Tiêu đề và danh mục --}}
                    <div class="mb-3">
                        <h1 class="card-title mb-2">{{ $post->title }}</h1>
                        <span class="badge bg-info">
                            <i class="fas fa-tag me-1"></i>{{ $post->category->name }}
                        </span>
                    </div>
                    
                    {{-- Ảnh thumbnail --}}
                    <div class="text-center mb-4">
                        <img src="{{ asset('storage/' . $post->thumbnail) }}" 
                             alt="Thumbnail" 
                             class="img-fluid rounded shadow-sm" 
                             style="max-height: 400px; object-fit: cover;">
                    </div>

                    {{-- Thông tin tác giả và thời gian --}}
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <span class="text-muted">
                                <i class="fas fa-user me-2"></i>{{ $post->user->name }}
                            </span>
                            <span class="text-muted ms-3">
                                <i class="fas fa-calendar-alt me-2"></i>
                                {{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y H:i') }}
                            </span>
                            <span class="text-muted ms-3">
                                <i class="fas fa-eye me-2"></i>
                                <span class="fw-bold">{{ number_format($post->views) }}</span> lượt xem
                            </span>
                        </div>
                        <div>
                            <span class="badge bg-primary me-2">
                                <i class="fas fa-thumbs-up me-1"></i>{{ $post->likes() }}
                            </span>
                            <span class="badge bg-danger">
                                <i class="fas fa-thumbs-down me-1"></i>{{ $post->dislikes() }}
                            </span>
                        </div>
                    </div>

                    {{-- Nội dung bài viết --}}
                    <div class="card-text mb-4 post-content">
                        {!! nl2br(e($post->content)) !!}
                    </div>

                    {{-- Nút like/dislike --}}
                    <div class="reaction-buttons mb-4">
                        @if(auth()->check() && auth()->user()->role === 'reader')
                            <form action="{{ route('like', ['post' => $post->id]) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn {{ $post->userReaction() && $post->userReaction()->reaction_type === 'like' ? 'btn-primary' : 'btn-outline-primary' }}">
                                    <i class="fas fa-thumbs-up"></i> Like ({{ $post->likes() }})
                                </button>
                            </form>

                            <form action="{{ route('unlike', ['post' => $post->id]) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn {{ $post->userReaction() && $post->userReaction()->reaction_type === 'dislike' ? 'btn-danger' : 'btn-outline-danger' }}">
                                    <i class="fas fa-thumbs-down"></i> Dislike ({{ $post->dislikes() }})
                                </button>
                            </form>
                        @else
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                Vui lòng đăng nhập với tài khoản reader để like/dislike bài viết.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Bài viết liên quan --}}
            @if($relatedPosts->count() > 0)
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title mb-4">
                        <i class="fas fa-link me-2"></i>Bài viết liên quan
                    </h3>
                    <div class="row g-4">
                        @foreach($relatedPosts as $relatedPost)
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <img src="{{ asset('storage/' . $relatedPost->thumbnail) }}" 
                                         class="card-img-top" 
                                         alt="Thumbnail"
                                         style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $relatedPost->title }}</h5>
                                        <p class="card-text text-muted small">
                                            <i class="fas fa-user me-1"></i>{{ $relatedPost->user->name }}
                                            <span class="ms-2">
                                                <i class="fas fa-calendar-alt me-1"></i>
                                                {{ \Carbon\Carbon::parse($relatedPost->created_at)->format('d/m/Y') }}
                                            </span>
                                        </p>
                                        <a href="{{ route('detailPost', $relatedPost->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-book-open me-1"></i>Đọc thêm
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .post-content {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #333;
    }
    .post-content p {
        margin-bottom: 1.5rem;
    }
    .card {
        border: none;
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
    }
</style>
@endpush
@endsection
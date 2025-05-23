@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h1 class="card-title mb-4">{{ $post->title }}</h1>
                    
                    <div class="text-center mb-4">
                        <img src="{{ asset('storage/' . $post->thumbnail) }}" 
                             alt="Thumbnail" 
                             class="img-fluid rounded" 
                             style="max-height: 400px; object-fit: cover;">
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <span class="text-muted">
                                <i class="fas fa-user me-2"></i>{{ $post->user->name }}
                            </span>
                            <span class="text-muted ms-3">
                                <i class="fas fa-calendar-alt me-2"></i>
                                {{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y H:i') }}
                            </span>
                        </div>
                        <div>
                            <span class="badge bg-primary me-2">
                                <i class="fas fa-thumbs-up me-1"></i>{{ $post->likes }}
                            </span>
                            <span class="badge bg-danger">
                                <i class="fas fa-thumbs-down me-1"></i>{{ $post->dislikes }}
                            </span>
                        </div>
                    </div>

                    <div class="card-text mb-4">
                        {!! nl2br(e($post->content)) !!}
                    </div>

                    <div class="d-flex justify-content-center gap-3">
                        <form action="{{ route('like') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="fas fa-thumbs-up me-2"></i>Like ({{ $post->likes }})
                            </button>
                        </form>

                        <form action="{{ route('unlike') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="fas fa-thumbs-down me-2"></i>Dislike ({{ $post->dislikes }})
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
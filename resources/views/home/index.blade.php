@extends('layouts.app')

@section('content')
<div class="posts-container">
    <h2>Bài Viết Mới Nhất</h2>
    <div class="posts">
        @foreach($posts as $post)
            <div class="post-card">
                <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="Thumbnail">
                <h3></h3>
                <h3><a href="{{ route('detailPost', $post->id) }}">{{ $post->title }}</a></h3>
                <p>Người tạo: {{ $post->user->name }}</p>
                <p>Ngày tạo: {{ $post->created_at->format('d/m/Y') }}</p>
                <p>{{ \Illuminate\Support\Str::limit($post->content, 100) }}</p>
            </div>
        @endforeach
    </div>
</div>
@endsection

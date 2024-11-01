@extends('layouts.app')

@section('content')
<div class="detail-post">
    <h1>{{ $post->title }}</h1>
    <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="Thumbnail">
    <p>{{ $post->content }}</p>
    <p class="time">Ngày tạo: {{ $post->created_at }}</p>
    <p class="author">Tác giả: {{ $post->user->name }}</p>

    <div class="interaction">
        <form action="{{ route('like') }}" method="POST">
            @csrf
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <button type="submit">Like:{{$post->likes}}</button>
        </form>

        <form action="{{ route('unlike') }}" method="POST">
            @csrf
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <button type="submit">Dislike:{{$post->dislikes}}</button>
        </form>
    </div>
</div>
@endsection
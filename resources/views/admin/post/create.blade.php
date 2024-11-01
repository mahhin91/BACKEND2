@extends('adminLayouts.app')

@section('content')
    <div class="create-port">
        <h1>Tạo bài viết mới</h1>
        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Tiêu đề</label><br>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="content">Nội dung</label><br>
                <textarea class="form-control" id="content" name="content" required></textarea>
            </div>
            <div class="form-group">
                <label for="thumbnail">Ảnh minh họa</label>
                <input type="file" class="form-control" id="thumbnail" name="thumbnail" required>
            </div>
            <div class="form-group">
                <label for="category_id">Danh mục</label><br>
                <select class="form-control" id="category_id" name="category_id" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Tạo bài viết</button>
        </form>
    </div>
@endsection
@extends('adminLayouts.app')

@section('content')
    <div class="create-port">
        <h1>Tạo danh mục</h1>
        <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Tên danh mục</label><br>
                <input type="name" class="form-control" id="name" name="name" required>
            </div>
            <button type="submit" class="btn btn-primary">Tạo bài viết</button>
        </form>
    </div>
@endsection
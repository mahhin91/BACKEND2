@extends('adminLayouts.app')

@section('content')
    <h1>Danh sách bài viết</h1>
    <a href="{{ route('category.create') }}" class="detailPost" >Tạo mới</a>
    <table>
        <thead>
            <tr>
                <th>Tên danh mục</th>
                <th>Thời gian tạo</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->created_at }}</td>
                        <td>
                            <form action="{{ route('category.delete', $category->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Xóa</button>
                            </form>
                        </td>
                    </tr>
            @endforeach
        </tbody>
    </table>
@endsection

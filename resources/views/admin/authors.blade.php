@extends('adminLayouts.app')

@section('content')
    <h1>Danh sách tác giả</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Ảnh đại diện</th>
                <th>Số lượng bài viết</th>
                <th>Danh sách bài viết</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($authors as $author)
                <tr>
                    <td>{{ $author->id }}</td>
                    <td>{{ $author->name }}</td>
                    <td>{{ $author->email }}</td>
                    <td><img src="{{ asset('storage/' . $author->avatar) }}" alt="Ảnh đại diện"></td>
                    <td>{{ $author->posts_count }}</td>
                    <td>
                        <a class="detailPost" href="{{ route('listOfPostByAuthor', $author->id) }}">Xem</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $authors->links('pagination::default') }}
@endsection

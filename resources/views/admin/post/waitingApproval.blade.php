@extends('adminLayouts.app')

@section('content')
    <h1>Chờ duyệt</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tiêu đề</th>
                <th>Tên tác giả</th>
                <th>Ngày tạo</th>
                <th>Ảnh minh họa</th>
                <th>Xác nhận</th>
                <th>Chức năng</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->author->name }}</td>
                    <td>{{ $post->created_at }}</td>
                    <td><img src="{{ asset('storage/' . $post->image) }}" alt="Ảnh minh họa"></td>
                    <td>
                        <a href="{{ route('posts.approve', $post->id) }}">Xác nhận</a>
                        <a href="{{ route('posts.reject', $post->id) }}">Không xác nhận</a>
                    </td>
                    <td>
                        <a href="{{ route('posts.show', $post->id) }}">Xem</a>
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $posts->links('pagination::default') }}
@endsection
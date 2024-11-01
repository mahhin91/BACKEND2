@extends('adminLayouts.app')

@section('content')
    <h1>Danh sách bài viết</h1>
    <table>
        <thead>
            <tr>
                @if(auth()->user()->role == 'admin')
                    <th>ID</th>
                    <th>Tiêu đề</th>
                    <th>Tên tác giả</th>
                    <th>Ngày tạo</th>
                    <th>Ảnh minh họa</th>
                    <th>Lượt thích</th>
                    <th>Trạng thái</th>
                    <th>Chức năng</th>
                @else
                    <th>ID</th>
                    <th>Tiêu đề</th>
                    <th>Ngày tạo</th>
                    <th>Ảnh minh họa</th>
                    <th>Xác nhận</th>
                    <th>Chức năng</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->title }}</td>
                    @if(auth()->user()->role == 'admin')
                        <td>{{ $post->author->name }}</td>
                        <td>{{ $post->created_at }}</td>
                        <td><img src="{{ asset('storage/' . $post->image) }}" alt="Ảnh minh họa"></td>
                        <td>{{ $post->likes }}</td>
                        <td>{{ $post->status }}</td>
                        <td>
                            <a href="{{ route('posts.show', $post->id) }}">Xem</a>
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Xóa</button>
                            </form>
                        </td>
                    @else
                        <td>{{ $post->created_at }}</td>
                        <td><img src="{{ asset('storage/' . $post->thumbnail) }}" alt="Ảnh minh họa"></td>
                        <td>{{ $post->status }}</td>
                        <td>
                            <a href="{{ route('detailPost', $post->id) }}">Xem</a>
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Xóa</button>
                            </form>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $posts->links('pagination::default') }}
@endsection
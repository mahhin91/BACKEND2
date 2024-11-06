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
                    <td>{{ $post->user_name }}</td>
                    <td>{{ $post->created_at }}</td>
                    <td><img src="{{ asset('storage/' . $post->thumbnail) }}" alt="Ảnh minh họa"></td>
                    <td>
                        <form action="{{ route('approve', $post->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit">Xác nhận</button>
                        </form>
                        <form action="{{ route('reject', $post->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit">Không xác nhận</button>
                        </form>
                    </td>
                    <td>
                        <a class="detailPost" href="{{ route('detailPost', $post->id) }}">Xem</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $posts->links('pagination::default') }}
@endsection
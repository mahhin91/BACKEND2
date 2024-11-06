@extends('adminLayouts.app')

@section('content')
    <h1>Danh sách bài viết</h1>
    <table>
        <thead>
            <tr>
                <th>Tiêu đề</th>
                <th>Tác giả</th>
                <th>Ảnh</th>
                <th>Thời gian tạo</th>
                <th>Trạng thái</th>
                <th>Like</th>
                <th>Dislike</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
                @if ($post->status == 'approved')
                    <tr>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->name }}</td>
                        <td><img src="{{ asset('storage/' . $post->thumbnail) }}" alt="Ảnh minh họa"></td>
                        <td>{{ $post->created_at }}</td>
                        <td><p class="status approved">Đã xác nhận</p></td>
                        <td>{{ $post->likes }}</td>
                        <td>{{ $post->dislikes }}</td>
                        <td>
                            <a class="detailPost" href="{{ route('detailPost', $post->id) }}">Xem</a>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
@endsection

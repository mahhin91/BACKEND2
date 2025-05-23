@extends('adminLayouts.app')

@section('content')
<div class="container-fluid px-0">
    <h1 class="mb-4">Danh sách bài viết</h1>
    <div class="card shadow">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            @if(auth()->user()->role == 'admin')
                                <th>ID</th>
                                <th>Tiêu đề</th>
                                <th>Tên tác giả</th>
                                <th>Ngày tạo</th>
                                <th>Ảnh minh họa</th>
                                <th>Lượt thích</th>
                                <th>Không thích</th>
                                <th>Trạng thái</th>
                                <th>Chức năng</th>
                            @else
                                <th>ID</th>
                                <th>Tiêu đề</th>
                                <th>Ngày tạo</th>
                                <th>Ảnh minh họa</th>
                                <th>Trạng thái</th>
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
                                    <td>{{ $author->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="Ảnh minh họa" class="rounded" width="60" height="40" style="object-fit:cover; border:1px solid #e2e8f0;">
                                    </td>
                                    <td>
                                        <span class="badge bg-primary"><i class="fas fa-thumbs-up"></i> {{ $post->likes }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-danger"><i class="fas fa-thumbs-down"></i> {{ $post->dislikes }}</span>
                                    </td>
                                    <td>
                                        @if ($post->status == 'pending')
                                            <span class="badge bg-warning text-dark">Chờ</span>
                                        @elseif ($post->status == 'rejected')
                                            <span class="badge bg-danger">Hủy</span>
                                        @elseif ($post->status == 'approved')
                                            <span class="badge bg-success">Đã xác nhận</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-outline-primary" href="{{ route('detailPost', $post->id) }}">
                                            <i class="fas fa-eye"></i> Xem
                                        </a>
                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i> Xóa
                                            </button>
                                        </form>
                                    </td>
                                @else
                                    <td>{{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="Ảnh minh họa" class="rounded" width="60" height="40" style="object-fit:cover; border:1px solid #e2e8f0;">
                                    </td>
                                    <td>
                                        @if ($post->status == 'pending')
                                            <span class="badge bg-warning text-dark">Chờ</span>
                                        @elseif ($post->status == 'rejected')
                                            <span class="badge bg-danger">Hủy</span>
                                        @elseif ($post->status == 'approved')
                                            <span class="badge bg-success">Đã xác nhận</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-outline-primary" href="{{ route('detailPost', $post->id) }}">
                                            <i class="fas fa-eye"></i> Xem
                                        </a>
                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i> Xóa
                                            </button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white py-3">
            <div class="d-flex justify-content-center">
                {{ $posts->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection
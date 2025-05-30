@extends('adminLayouts.app')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Danh sách bài viết</h1>
    </div>

    <div class="card shadow">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Tiêu đề</th>
                            <th>Tác giả</th>
                            <th>Ảnh</th>
                            <th>Thời gian tạo</th>
                            <th>Trạng thái</th>
                            <th>Lượt xem</th>
                            <th>Like</th>
                            <th>Dislike</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($posts as $post)
                            <tr>
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->user_name }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="Ảnh minh họa" class="rounded" width="60" height="40" style="object-fit:cover; border:1px solid #e2e8f0;">
                                </td>
                                <td>{{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y H:i') }}</td>
                                <td>
                                    @if($post->status == 'approved')
                                        <span class="badge bg-success">Đã xác nhận</span>
                                    @elseif($post->status == 'pending')
                                        <span class="badge bg-warning">Đang chờ duyệt</span>
                                    @else
                                        <span class="badge bg-danger">Đã từ chối</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-eye"></i> {{ number_format($post->views) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-primary"><i class="fas fa-thumbs-up"></i> {{ $post->likes() }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-danger"><i class="fas fa-thumbs-down"></i> {{ $post->dislikes() }}</span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-sm btn-outline-primary" href="{{ route('detailPost', $post->id) }}">
                                            <i class="fas fa-eye"></i> Xem
                                        </a>
                                        @if($post->status == 'pending')
                                            <form action="{{ route('admin.posts.approve', $post->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-success">
                                                    <i class="fas fa-check"></i> Duyệt
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.posts.reject', $post->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-times"></i> Từ chối
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $posts->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

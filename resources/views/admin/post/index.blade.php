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
                                    <td>{{ $post->user_name }}</td>
                                    <td>
                                        <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="Ảnh minh họa" class="rounded" width="60" height="40" style="object-fit:cover; border:1px solid #e2e8f0;">
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <span class="badge bg-success">Đã xác nhận</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary"><i class="fas fa-thumbs-up"></i> {{ $post->likes }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-danger"><i class="fas fa-thumbs-down"></i> {{ $post->dislikes }}</span>
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-outline-primary" href="{{ route('detailPost', $post->id) }}">
                                            <i class="fas fa-eye"></i> Xem
                                        </a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

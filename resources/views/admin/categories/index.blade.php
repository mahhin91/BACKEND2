@extends('adminLayouts.app')

@section('content')
<div class="container-fluid px-0">
    <h1 class="mb-4">Danh sách danh mục</h1>
    <div class="mb-3">
        <a href="{{ route('category.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-1"></i> Tạo mới
        </a>
    </div>
    <div class="card shadow">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
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
                                <td>{{ \Carbon\Carbon::parse($category->created_at)->format('d/m/Y H:i') }}</td>
                                <td>
                                    <form action="{{ route('category.delete', $category->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i> Xóa
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

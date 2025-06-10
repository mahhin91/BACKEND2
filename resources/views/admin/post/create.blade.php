@extends('adminLayouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Tạo bài viết mới</h1>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('author.posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-3">
                    <label for="title" class="form-label">Tiêu đề</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                           id="title" name="title" value="{{ old('title') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="category_id" class="form-label">Danh mục</label>
                    <select class="form-select @error('category_id') is-invalid @enderror" 
                            id="category_id" name="category_id" required>
                        <option value="">Chọn danh mục</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="thumbnail" class="form-label">Ảnh thumbnail</label>
                    <input type="file" class="form-control @error('thumbnail') is-invalid @enderror" 
                           id="thumbnail" name="thumbnail" accept="image/*" required>
                    <div class="form-text">Chấp nhận: JPG, JPEG, PNG. Tối đa 2MB</div>
                    @error('thumbnail')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Nội dung</label>
                    <textarea class="form-control @error('content') is-invalid @enderror" 
                              id="content" name="content" rows="10" required>{{ old('content') }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Tạo bài viết
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Preview ảnh trước khi upload
    document.getElementById('thumbnail').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Kiểm tra kích thước file
            if (file.size > 2 * 1024 * 1024) { // 2MB
                alert('File quá lớn. Kích thước tối đa là 2MB');
                this.value = '';
                return;
            }

            // Kiểm tra loại file
            if (!file.type.match('image.*')) {
                alert('Vui lòng chọn file ảnh');
                this.value = '';
                return;
            }

            // Tạo preview
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.createElement('img');
                preview.src = e.target.result;
                preview.style.maxWidth = '200px';
                preview.style.marginTop = '10px';
                
                const container = document.getElementById('thumbnail').parentElement;
                const oldPreview = container.querySelector('img');
                if (oldPreview) {
                    container.removeChild(oldPreview);
                }
                container.appendChild(preview);
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
@endsection
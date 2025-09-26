@extends('admin.layouts.main_layout')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0 text-white">Thêm sản phẩm</h4>
        </div>
        <div class="card-body">
            <form
                action="{{ route('products.store') }}"
                method="POST"
                enctype="multipart/form-data">
                @csrf

                <!-- Tên sản phẩm -->
                <div class="mb-3">
                    <label class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                    <input
                        type="text"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}">
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Mô tả -->
                <div class="mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea
                        name="description"
                        class="form-control @error('description') is-invalid @enderror"
                        rows="3">{{ old('description') }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Giá, số lượng -->
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Giá gốc</label>
                        <input
                            type="number"
                            step="0.01"
                            name="base_price"
                            value="{{ old('base_price') }}"
                            class="form-control @error('base_price') is-invalid @enderror">
                        @error('base_price')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Giá khuyến mãi</label>
                        <input
                            type="number"
                            step="0.01"
                            name="sale_price"
                            value="{{ old('sale_price') }}"
                            class="form-control @error('sale_price') is-invalid @enderror">
                        @error('sale_price')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Số lượng</label>
                        <input
                            type="number"
                            name="stock"
                            value="{{ old('stock') }}"
                            class="form-control @error('stock') is-invalid @enderror">
                        @error('stock')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Danh mục -->
                <div class="mb-3">
                    <label class="form-label">Danh mục</label>
                    <select
                        name="category_id"
                        class="form-select @error('category_id') is-invalid @enderror">
                        <option value="">-- Chọn danh mục --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Ảnh sản phẩm -->
                <div class="mb-4">
                    <label class="form-label">Ảnh sản phẩm</label>
                    <input
                        type="file"
                        name="images[]"
                        multiple
                        class="form-control @error('images') is-invalid @enderror">
                    @error('images')
                    <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Trạng thái -->
                <div class="form-check form-switch mb-4">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="is_active"
                        id="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                    <label
                        class="form-check-label"
                        for="is_active">Kích hoạt</label>
                </div>

                <hr>

                <!-- Biến thể -->
                <h5 class="mb-3">Biến thể</h5>
                <div id="variants-wrapper"></div>
                <button
                    type="button"
                    class="btn btn-outline-secondary mb-3"
                    onclick="addVariant()">+ Thêm biến thể
                </button>

                <hr>
                <button
                    type="submit"
                    class="btn btn-success">💾 Lưu sản phẩm
                </button>
            </form>
        </div>
    </div>

    <script>
        let variantIndex = 0;

        function addVariant() {
            let html = `
        <div class="variant-item border rounded p-3 mt-3 bg-light position-relative">
            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2" onclick="removeVariant(this)">X</button>
            <h6 class="mb-3 text-primary">Biến thể</h6>
            <div class="row">
                <div class="col-md-3 mb-2">
                    <label class="form-label">Tên biến thể</label>
                    <input type="text" name="variants[${variantIndex}][variant_name]" class="form-control">
                </div>
                <div class="col-md-2 mb-2">
                    <label class="form-label">Giá</label>
                    <input type="number" step="0.01" name="variants[${variantIndex}][price]" class="form-control">
                </div>
                <div class="col-md-2 mb-2">
                    <label class="form-label">Giá KM</label>
                    <input type="number" step="0.01" name="variants[${variantIndex}][sale_price]" class="form-control">
                </div>
                <div class="col-md-2 mb-2">
                    <label class="form-label">Số lượng</label>
                    <input type="number" name="variants[${variantIndex}][stock]" class="form-control">
                </div>
                <div class="col-md-12 mt-2">
                    <label class="form-label">Ảnh biến thể</label>
                    <input type="file" name="variants[${variantIndex}][images][]" multiple class="form-control">
                </div>
            </div>
        </div>
        `;
            document.getElementById('variants-wrapper').insertAdjacentHTML('beforeend', html);
            variantIndex++;
        }

        function removeVariant(btn) {
            btn.closest('.variant-item').remove();
        }
    </script>
@endsection

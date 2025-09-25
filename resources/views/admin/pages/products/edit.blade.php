@extends('admin.layouts.main_layout')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0 text-white">✏️ Sửa sản phẩm</h4>
        </div>
        <div class="card-body">
            <form
                action="{{ route('products.update', $product) }}"
                method="POST"
                enctype="multipart/form-data">
                @csrf @method('PUT')

                <!-- thông tin cơ bản -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Tên sản phẩm</label>
                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name', $product->name) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Mô tả</label>
                    <textarea
                        name="description"
                        class="form-control"
                        rows="4">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Giá gốc</label>
                        <input
                            type="number"
                            step="0.01"
                            name="base_price"
                            value="{{ old('base_price', $product->base_price) }}"
                            class="form-control">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Giá KM</label>
                        <input
                            type="number"
                            step="0.01"
                            name="sale_price"
                            value="{{ old('sale_price', $product->sale_price) }}"
                            class="form-control">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Số lượng</label>
                        <input
                            type="number"
                            name="stock"
                            value="{{ old('stock', $product->stock) }}"
                            class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Danh mục</label>
                    <select
                        name="category_id"
                        class="form-select">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" @selected($cat->id == $product->category_id)>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- ảnh sản phẩm -->
                <div class="mb-4">
                    <label class="form-label fw-bold">Ảnh sản phẩm</label>
                    <div class="row g-3">
                        @foreach($product->images as $img)
                            <div class="col-md-3">
                                <div class="border rounded p-2 text-center position-relative">
                                    <img
                                        src="{{ asset('storage/'.$img->image_url) }}"
                                        class="img-fluid rounded"
                                        style="height:120px;object-fit:cover">
                                    <div class="mt-2">
                                        <label class="form-check-label me-2">
                                            <input
                                                type="radio"
                                                name="main_image"
                                                value="{{ $img->id }}"
                                                class="form-check-input" @checked($img->is_main)> Ảnh chính
                                        </label>
                                    </div>
                                    <div>
                                        <label class="form-check-label text-danger">
                                            <input
                                                type="checkbox"
                                                name="delete_images[]"
                                                value="{{ $img->id }}"
                                                class="form-check-input"> Xoá
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <input
                        type="file"
                        name="images[]"
                        multiple
                        class="form-control mt-3">
                </div>

                <!-- biến thể -->
                <h5 class="fw-bold mt-4">🧩 Biến thể</h5>
                <div id="variants-wrapper">
                    @foreach($product->variants as $variant)
                        <div class="variant-item border rounded shadow-sm p-3 mt-3 bg-light">
                            <input
                                type="hidden"
                                name="variants[{{ $variant->id }}][id]"
                                value="{{ $variant->id }}">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Tên biến thể</label>
                                    <input
                                        type="text"
                                        name="variants[{{ $variant->id }}][variant_name]"
                                        value="{{ $variant->variant_name }}"
                                        class="form-control">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Giá</label>
                                    <input
                                        type="number"
                                        step="0.01"
                                        name="variants[{{ $variant->id }}][price]"
                                        value="{{ $variant->price }}"
                                        class="form-control">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Giá KM</label>
                                    <input
                                        type="number"
                                        step="0.01"
                                        name="variants[{{ $variant->id }}][sale_price]"
                                        value="{{ $variant->sale_price }}"
                                        class="form-control">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Số lượng</label>
                                    <input
                                        type="number"
                                        name="variants[{{ $variant->id }}][stock]"
                                        value="{{ $variant->stock }}"
                                        class="form-control">
                                </div>
                            </div>

                            <!-- ảnh biến thể -->
                            <div class="mt-3">
                                <label class="form-label fw-bold">Ảnh biến thể</label>
                                <div class="row g-3">
                                    @foreach($variant->images as $img)
                                        <div class="col-md-3">
                                            <div class="border rounded p-2 text-center">
                                                <img
                                                    src="{{ asset('storage/'.$img->image_url) }}"
                                                    class="img-fluid rounded"
                                                    style="height:100px;object-fit:cover">
                                                <div class="mt-1">
                                                    <label class="form-check-label text-danger">
                                                        <input
                                                            type="checkbox"
                                                            name="variants[{{ $variant->id }}][delete_images][]"
                                                            value="{{ $img->id }}"
                                                            class="form-check-input"> Xoá
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <input
                                    type="file"
                                    name="variants[{{ $variant->id }}][images][]"
                                    multiple
                                    class="form-control mt-2">
                            </div>

                            <!-- nút xoá biến thể -->
                            <div class="mt-3">
                                <label class="form-check-label text-danger fw-bold">
                                    <input
                                        type="checkbox"
                                        name="variants[{{ $variant->id }}][_delete]"
                                        value="1"
                                        class="form-check-input"> Xoá biến thể này
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button
                    type="button"
                    class="btn btn-outline-secondary mt-3"
                    onclick="addVariant()">+ Thêm biến thể
                </button>

                <hr>
                <button
                    type="submit"
                    class="btn btn-primary">💾 Cập nhật
                </button>
            </form>
        </div>
    </div>

    <script>
        let variantIndex = 0;

        function addVariant() {
            let html = `
            <div class="variant-item border rounded shadow-sm p-3 mt-3 bg-light">
                <h6 class="fw-bold">Biến thể mới</h6>
                <div class="row g-3">
                    <div class="col-md-3"><label class="form-label">Tên biến thể</label><input type="text" name="variants[new${variantIndex}][variant_name]" class="form-control"></div>
                    <div class="col-md-2"><label class="form-label">Giá</label><input type="number" step="0.01" name="variants[new${variantIndex}][price]" class="form-control"></div>
                    <div class="col-md-2"><label class="form-label">Giá KM</label><input type="number" step="0.01" name="variants[new${variantIndex}][sale_price]" class="form-control"></div>
                    <div class="col-md-2"><label class="form-label">Số lượng</label><input type="number" name="variants[new${variantIndex}][stock]" class="form-control"></div>
                </div>
                <div class="mt-2">
                    <label class="form-label fw-bold">Ảnh biến thể</label>
                    <input type="file" name="variants[new${variantIndex}][images][]" multiple class="form-control">
                </div>
            </div>`;
            document.getElementById('variants-wrapper').insertAdjacentHTML('beforeend', html);
            variantIndex++;
        }
    </script>
@endsection

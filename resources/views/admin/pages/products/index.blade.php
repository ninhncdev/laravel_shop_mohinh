@extends('admin.layouts.main_layout')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4>Danh sách sản phẩm</h4>
            <a
                href="{{ route('products.create') }}"
                class="btn btn-primary">+ Thêm sản phẩm</a>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <table class="table table-bordered table-striped align-middle">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Ảnh</th>
                    <th>Tên</th>
                    <th>SKU</th>
                    <th>Danh mục</th>
                    <th>Giá</th>
                    <th>Kho</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
                </thead>
                <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>

                        {{-- Ảnh đại diện --}}
                        <td>
                            @php
                                $mainImage = $product->images->firstWhere('is_main', true) ?? $product->images->first();
                            @endphp

                            @if($mainImage)
                                <img
                                    src="{{ asset('storage/'.$mainImage->image_url) }}"
                                    alt="Ảnh"
                                    style="width:60px; height:60px; object-fit:cover; border-radius:4px;">
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>

                        {{-- Giới hạn tên + tooltip --}}
                        <td>
                            <span title="{{ $product->name }}">
                                {{ \Illuminate\Support\Str::limit($product->name, 30) }}
                            </span>
                        </td>

                        {{-- SKU --}}
                        <td><span class="badge bg-secondary">{{ $product->sku }}</span></td>

                        <td>{{ $product->category->name ?? '—' }}</td>
                        <td>{{ number_format($product->base_price) }} đ</td>
                        <td>{{ $product->stock }}</td>
                        <td>
                            @if($product->is_active)
                                <span class="badge bg-success">Hoạt động</span>
                            @else
                                <span class="badge bg-danger">Ngừng</span>
                            @endif
                        </td>
                        <td>
                            <a
                                href="{{ route('products.edit', $product) }}"
                                class="btn btn-sm btn-warning">Sửa</a>
                            <form
                                action="{{ route('products.destroy', $product) }}"
                                method="POST"
                                style="display:inline-block">
                                @csrf
                                @method('DELETE')
                                <button
                                    onclick="return confirm('Xóa sản phẩm này?')"
                                    class="btn btn-sm btn-danger">
                                    Xóa
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td
                            colspan="9"
                            class="text-center">Không có sản phẩm
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection

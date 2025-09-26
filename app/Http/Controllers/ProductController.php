<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\ProductVariantImage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    const PATH = 'admin.pages.products.';

    public function index()
    {
        $products = Product::with('category', 'images')->paginate(10);
        return view(self::PATH . 'index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view(self::PATH . 'create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['is_active'] = $request->boolean('is_active');

            $data['sku'] = generateSku('PROD');
            $product = Product::create($data);
            // ảnh sản phẩm
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $img) {
                    $path = $img->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_url' => $path,
                    ]);
                }
            }

            // biến thể
            if ($request->has('variants')) {
                foreach ($request->variants as $variantData) {
                    $variant = ProductVariant::create([
                        'product_id' => $product->id,
                        'variant_name' => $variantData['variant_name'],
                        'price' => $variantData['price'],
                        'sale_price' => $variantData['sale_price'] ?? null,
                        'sku' => generateSku('VAR'),
                        'stock' => $variantData['stock'],
                    ]);

                    // ảnh biến thể
                    if (isset($variantData['images'])) {
                        foreach ($variantData['images'] as $vImg) {
                            $path = $vImg->store('variants', 'public');
                            ProductVariantImage::create([
                                'product_variant_id' => $variant->id,
                                'image_url' => $path,
                            ]);
                        }
                    }
                }
            }

            DB::commit();
            return redirect()->route('products.index')->with('success', 'Thêm sản phẩm thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view(self::PATH . 'edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Product $product)
    {
        try {
            $data = $request->all();
            $data['is_active'] = $request->boolean('is_active');

            $product->update($data);

            // xử lý ảnh cũ cần xoá
            if ($request->filled('delete_images')) {
                foreach ($request->delete_images as $imgId) {
                    $img = ProductImage::find($imgId);
                    if ($img) {
                        \Storage::disk('public')->delete($img->image_url);
                        $img->delete();
                    }
                }
            }

            // xử lý ảnh mới
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $img) {
                    $path = $img->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_url' => $path,
                        'is_main' => false,
                    ]);
                }
            }

            // cập nhật ảnh chính
            if ($request->filled('main_image')) {
                ProductImage::where('product_id', $product->id)->update(['is_main' => false]);
                ProductImage::where('id', $request->main_image)->update(['is_main' => true]);
            }

            // xử lý biến thể
            if ($request->filled('variants')) {
                foreach ($request->variants as $variantId => $variantData) {
                    if (isset($variantData['_delete']) && $variantData['_delete'] == 1) {
                        $variant = ProductVariant::find($variantId);
                        if ($variant) {
                            $variant->images()->delete();
                            $variant->delete();
                        }
                        continue;
                    }

                    if (is_numeric($variantId)) {
                        // update biến thể cũ
                        $variant = ProductVariant::find($variantId);
                        if ($variant) {
                            $variant->update([
                                'variant_name' => $variantData['variant_name'],
                                'price' => $variantData['price'],
                                'sale_price' => $variantData['sale_price'],
                                'stock' => $variantData['stock'],
                            ]);

                            // xoá ảnh cũ
                            if (!empty($variantData['delete_images'])) {
                                foreach ($variantData['delete_images'] as $imgId) {
                                    $img = ProductVariantImage::find($imgId);
                                    if ($img) {
                                        \Storage::disk('public')->delete($img->image_url);
                                        $img->delete();
                                    }
                                }
                            }

                            // thêm ảnh mới
                            if (!empty($variantData['images'])) {
                                foreach ($variantData['images'] as $img) {
                                    $path = $img->store('variants', 'public');
                                    $variant->images()->create(['image_url' => $path]);
                                }
                            }
                        }
                    } else {
                        // thêm mới biến thể
                        $variant = $product->variants()->create([
                            'variant_name' => $variantData['variant_name'],
                            'price' => $variantData['price'],
                            'sale_price' => $variantData['sale_price'],
                            'stock' => $variantData['stock'],
                        ]);

                        if (!empty($variantData['images'])) {
                            foreach ($variantData['images'] as $img) {
                                $path = $img->store('variants', 'public');
                                $variant->images()->create(['image_url' => $path]);
                            }
                        }
                    }
                }
            }

            return redirect()->route('products.index')->with('success', 'Cập nhật sản phẩm thành công');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}

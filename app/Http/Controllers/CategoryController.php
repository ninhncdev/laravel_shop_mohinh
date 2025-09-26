<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    const  PATH = "admin.pages.category.";

    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->paginate(3);
        return view(self::PATH . 'index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::all(); // để chọn parent
        return view(self::PATH . 'create', compact('categories'));
    }

    public function store(StoreRequest $request)
    {
        try {
            $data = $request->all();
            $data['is_active'] = $request->boolean('is_active');
            Category::create($data);
            return redirect()->route('category.index')->with('success', 'Tạo category thành công!');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->with('error', "Có lỗi xảy ra vui lòng thử lại!!");
        }
    }

    public function edit(Category $category)
    {
        $categories = Category::where('id', '!=', $category->id)->get();
        return view(self::PATH . 'edit', compact('category', 'categories'));
    }

    public function update(UpdateRequest $request, Category $category)
    {
        try {
            $data = $request->all();
            $data['is_active'] = $request->boolean('is_active');
            $category->update($data);
            return redirect()->route('category.index')->with('success', 'Cập nhật category thành công!');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->with('error', "Có lỗi xảy ra vui lòng thử lại!!");
        }

    }
}

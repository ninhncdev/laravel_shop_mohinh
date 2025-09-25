<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
//            'sku' => 'required|string|max:50|unique:products,sku',
            'name' => 'required|string|max:255',
//            'slug' => 'required|string|unique:products,slug',
            'base_price' => 'required|min:0',
            'sale_price' => 'nullable|min:0|lt:base_price',
            'stock' => 'required',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',

            // biến thể
//            'variants.*.sku' => 'required|string|max:50|unique:product_variants,sku',
//            'variants.*.variant_name' => 'required|string|max:255',
//            'variants.*.price' => 'required|numeric|min:0',
//            'variants.*.sale_price' => 'nullable|numeric|min:0|lt:variants.*.price',
//            'variants.*.stock' => 'required|integer|min:0',
//            'variants.*.images.*' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ];
    }
}

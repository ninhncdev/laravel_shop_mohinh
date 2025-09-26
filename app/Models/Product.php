<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'sku', 'name', 'slug', 'description', 'base_price', 'sale_price', 'stock', 'category_id', 'is_active'
    ];

    protected static function booted()
    {
        static::creating(function ($product) {
            $base = Str::slug($product->name);
            $product->slug = static::uniqueSlug($base);
        });

        static::updating(function ($product) {
            if ($product->isDirty('name')) {
                $base = Str::slug($product->name);
                $product->slug = static::uniqueSlug($base, $product->id);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    protected static function uniqueSlug(string $base, ?int $ignoreId = null): string
    {
        $slug = $base;
        $i = 1;
        while (static::where('slug', $slug)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }
        return $slug;
    }
}

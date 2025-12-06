<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'is_active',
    ];

    // Relaciones
    public function categories()
    {
        return $this->belongsToMany(ProductCategory::class, 'category_product');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function carts() {
        return $this->belongsToMany(Cart::class, 'cart_items')
                    ->withPivot('quantity', 'price_at_purchase')
                    ->withTimestamps();
    }

    public function orders() {
        return $this->belongsToMany(Order::class, 'order_items')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    // Campos que permitimos llenar mediante create() o update()
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    /**
     * Relación: Un item pertenece a una orden.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relación: Un item del pedido hace referencia a un producto.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Formateo automático: Asegura que el precio siempre sea un decimal.
     */
    protected $casts = [
        'price' => 'decimal:2',
    ];
}
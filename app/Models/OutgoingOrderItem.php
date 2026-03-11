<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutgoingOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'outgoing_order_id',
        'product_id',
        'quantity',
        'price',
        'total',
    ];

    protected $casts = [
        'quantity' => 'decimal:3',
        'price' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function outgoingOrder()
    {
        return $this->belongsTo(OutgoingOrder::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'warehouse_cell_id',
        'user_id',
        'type',
        'quantity',
        'document_type',
        'document_id',
        'reason',
    ];

    protected $casts = [
        'quantity' => 'decimal:3',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouseCell()
    {
        return $this->belongsTo(WarehouseCell::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function document()
    {
        return $this->morphTo('document', 'document_type', 'document_id');
    }
}
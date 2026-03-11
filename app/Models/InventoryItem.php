<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_id',
        'product_id',
        'warehouse_cell_id',
        'expected_quantity',
        'actual_quantity',
        'difference',
        'reason',
    ];

    protected $casts = [
        'expected_quantity' => 'decimal:3',
        'actual_quantity' => 'decimal:3',
        'difference' => 'decimal:3',
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouseCell()
    {
        return $this->belongsTo(WarehouseCell::class);
    }
}
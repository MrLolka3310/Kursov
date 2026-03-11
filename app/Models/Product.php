<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'name',
        'description',
        'category_id',
        'unit',
        'purchase_price',
        'selling_price',
        'min_stock',
        'max_stock',
        'image',
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function incomingInvoiceItems()
    {
        return $this->hasMany(IncomingInvoiceItem::class);
    }

    public function outgoingOrderItems()
    {
        return $this->hasMany(OutgoingOrderItem::class);
    }

    public function inventoryItems()
    {
        return $this->hasMany(InventoryItem::class);
    }

    public function getCurrentStockAttribute()
    {
        $incoming = $this->stockMovements()
            ->where('type', 'INCOMING')
            ->sum('quantity');
            
        $outgoing = $this->stockMovements()
            ->where('type', 'OUTGOING')
            ->sum('quantity');
            
        $correction = $this->stockMovements()
            ->where('type', 'CORRECTION')
            ->sum('quantity');
            
        return $incoming - $outgoing + $correction;
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseCell extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'zone',
        'rack',
        'shelf',
        'description',
        'max_weight',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'max_weight' => 'decimal:2',
    ];

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function incomingInvoices()
    {
        return $this->hasMany(IncomingInvoice::class);
    }

    public function outgoingOrders()
    {
        return $this->hasMany(OutgoingOrder::class);
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
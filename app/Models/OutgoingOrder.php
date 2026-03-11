<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutgoingOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'order_date',
        'customer_id',
        'user_id',
        'warehouse_cell_id',
        'total_amount',
        'status',
        'notes',
    ];

    protected $casts = [
        'order_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function warehouseCell()
    {
        return $this->belongsTo(WarehouseCell::class);
    }

    public function items()
    {
        return $this->hasMany(OutgoingOrderItem::class);
    }

    public function stockMovements()
    {
        return $this->morphMany(StockMovement::class, 'document', 'document_type', 'document_id');
    }
}
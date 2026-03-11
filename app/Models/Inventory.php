<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'inventory_date',
        'user_id',
        'status',
        'notes',
    ];

    protected $casts = [
        'inventory_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(InventoryItem::class);
    }

    public function stockMovements()
    {
        return $this->morphMany(StockMovement::class, 'document', 'document_type', 'document_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact_person',
        'phone',
        'email',
        'address',
        'inn',
        'discount',
        'customer_type',
    ];

    protected $casts = [
        'discount' => 'decimal:2',
    ];

    public function outgoingOrders()
    {
        return $this->hasMany(OutgoingOrder::class);
    }
}
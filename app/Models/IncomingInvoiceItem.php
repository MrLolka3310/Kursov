<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomingInvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'incoming_invoice_id',
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

    public function incomingInvoice()
    {
        return $this->belongsTo(IncomingInvoice::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
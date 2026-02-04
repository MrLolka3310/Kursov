<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomeItem extends Model
{
    public $timestamps = false;

    protected $fillable = ['income_id', 'product_id', 'quantity'];

    public function income()
    {
        return $this->belongsTo(Income::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

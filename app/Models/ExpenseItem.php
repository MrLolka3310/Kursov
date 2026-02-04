<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseItem extends Model
{
    public $timestamps = false;

    protected $fillable = ['expense_id', 'product_id', 'quantity'];

    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

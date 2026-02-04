<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'sku', 'category_id', 'price', 'unit'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function incomeItems()
    {
        return $this->hasMany(IncomeItem::class);
    }

    public function expenseItems()
    {
        return $this->hasMany(ExpenseItem::class);
    }
}

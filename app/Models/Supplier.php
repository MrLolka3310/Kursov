<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'phone', 'email'];

    public function incomes()
    {
        return $this->hasMany(Income::class);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Stock;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::with(['warehouse', 'product'])->get();

        return view('stocks.index', compact('stocks'));
    }
}


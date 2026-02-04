<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Income;
use App\Models\Expense;

class ReportController extends Controller
{
    public function stocks()
    {
        $stocks = Stock::with(['warehouse', 'product'])
            ->orderBy('warehouse_id')
            ->get();

        return view('reports.stocks', compact('stocks'));
    }

public function movements()
{
    return view('reports.movements', [
        'incomes' => Income::with('warehouse')->get(),
        'expenses' => Expense::with('warehouse')->get(),
    ]);
}
}


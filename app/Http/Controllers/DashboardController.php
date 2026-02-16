<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Stock;
use App\Models\Income;
use App\Models\Expense;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'total_warehouses' => Warehouse::count(),
            'total_categories' => Category::count(),
            'total_suppliers' => Supplier::count(),
            'total_stock' => Stock::sum('quantity'),
            'total_incomes' => Income::count(),
            'total_expenses' => Expense::count(),
        ];

        $recentIncomes = Income::with('warehouse', 'user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentExpenses = Expense::with('warehouse', 'user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact('stats', 'recentIncomes', 'recentExpenses'));
    }
}


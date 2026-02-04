<?php

namespace App\Http\Controllers;

use App\Models\{
    Income, IncomeItem, Warehouse, Supplier, Product, Stock
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncomeController extends Controller
{
    public function index()
    {
        return view('incomes.index', [
            'incomes' => Income::with('warehouse', 'supplier')->get()
        ]);
    }

    public function create()
    {
        return view('incomes.create', [
            'warehouses' => Warehouse::all(),
            'suppliers' => Supplier::all(),
            'products' => Product::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'products' => 'required|array',
            'products.*' => 'numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {

            $income = Income::create([
                'warehouse_id' => $request->warehouse_id,
                'supplier_id' => $request->supplier_id,
                'user_id' => auth()->id(),
            ]);

            foreach ($request->products as $productId => $qty) {
                if ($qty <= 0) continue;

                IncomeItem::create([
                    'income_id' => $income->id,
                    'product_id' => $productId,
                    'quantity' => $qty,
                ]);

                $stock = Stock::firstOrCreate(
                    [
                        'warehouse_id' => $request->warehouse_id,
                        'product_id' => $productId,
                    ],
                    ['quantity' => 0]
                );

                $stock->increment('quantity', $qty);
            }
        });

        return redirect('/incomes');
    }

    public function show(Income $income)
    {
        return view('incomes.show', [
            'income' => $income->load('items.product')
        ]);
    }
}


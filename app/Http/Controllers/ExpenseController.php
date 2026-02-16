<?php

namespace App\Http\Controllers;

use App\Models\{
    Expense, ExpenseItem, Warehouse, Product, Stock
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    public function index()
    {
        return view('expenses.index', [
            'expenses' => Expense::with('warehouse')->get()
        ]);
    }

    public function create()
    {
        $warehouses = Warehouse::all();
        $products = Product::with('category')->get();
        
        // Get stock for each product (default to 0 if no stock record)
        $stocks = [];
        foreach ($products as $product) {
            $stocks[$product->id] = 0;
        }
        
        // Get actual stock if warehouse is selected
        $selectedWarehouseId = request('warehouse_id');
        if ($selectedWarehouseId) {
            $warehouseStocks = Stock::where('warehouse_id', $selectedWarehouseId)->get();
            foreach ($warehouseStocks as $stock) {
                $stocks[$stock->product_id] = $stock->quantity;
            }
        }
        
        return view('expenses.create', [
            'warehouses' => $warehouses,
            'products' => $products,
            'stocks' => $stocks,
        ]);
    }

    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {

            $expense = Expense::create([
                'warehouse_id' => $request->warehouse_id,
                'user_id' => auth()->id(),
            ]);

            foreach ($request->products as $productId => $qty) {
                if ($qty <= 0) continue;

                $stock = Stock::where('warehouse_id', $request->warehouse_id)
                    ->where('product_id', $productId)
                    ->lockForUpdate()
                    ->first();

                if (!$stock || $stock->quantity < $qty) {
                    abort(400, 'Недостаточно товара на складе');
                }

                ExpenseItem::create([
                    'expense_id' => $expense->id,
                    'product_id' => $productId,
                    'quantity' => $qty,
                ]);

                $stock->decrement('quantity', $qty);
            }
        });

        return redirect('/expenses');
    }

    public function show(Expense $expense)
    {
        return view('expenses.show', [
            'expense' => $expense->load('items.product')
        ]);
    }
}

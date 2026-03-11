<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use App\Models\IncomingInvoice;
use App\Models\OutgoingOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function stockReport(Request $request)
    {
        $query = Product::with('category');
        
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        
        $products = $query->get();
        
        foreach ($products as $product) {
            $product->current_stock = $product->current_stock;
            $product->stock_value = $product->current_stock * $product->purchase_price;
        }
        
        $totalValue = $products->sum('stock_value');
        
        return view('reports.stock', compact('products', 'totalValue'));
    }

    public function movementReport(Request $request)
    {
        $request->validate([
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
        ]);

        $query = StockMovement::with(['product', 'user', 'warehouseCell']);
        
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $movements = $query->latest()->paginate(50);
        
        return view('reports.movements', compact('movements'));
    }

    public function turnoverReport(Request $request)
    {
        $request->validate([
            'year' => 'nullable|integer|min:2000|max:2100',
            'month' => 'nullable|integer|min:1|max:12',
        ]);

        $year = $request->year ?? now()->year;
        $month = $request->month ?? now()->month;

        $startDate = "{$year}-{$month}-01";
        $endDate = date('Y-m-t', strtotime($startDate));

        $turnover = Product::select('products.*')
            ->selectSub(function($query) use ($startDate, $endDate) {
                $query->from('stock_movements')
                    ->whereColumn('product_id', 'products.id')
                    ->where('type', 'INCOMING')
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->select(DB::raw('COALESCE(SUM(quantity), 0)'));
            }, 'incoming_quantity')
            ->selectSub(function($query) use ($startDate, $endDate) {
                $query->from('stock_movements')
                    ->whereColumn('product_id', 'products.id')
                    ->where('type', 'OUTGOING')
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->select(DB::raw('COALESCE(SUM(quantity), 0)'));
            }, 'outgoing_quantity')
            ->with('category')
            ->get();

        return view('reports.turnover', compact('turnover', 'year', 'month'));
    }
}
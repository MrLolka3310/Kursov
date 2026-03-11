<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\IncomingInvoice;
use App\Models\OutgoingOrder;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $todayIncoming = IncomingInvoice::whereDate('created_at', today())->count();
        $todayOutgoing = OutgoingOrder::whereDate('created_at', today())->count();
        $lowStockProducts = Product::whereRaw('(SELECT COALESCE(SUM(quantity), 0) FROM stock_movements WHERE product_id = products.id AND type = "INCOMING") - (SELECT COALESCE(SUM(quantity), 0) FROM stock_movements WHERE product_id = products.id AND type = "OUTGOING") <= min_stock')->count();
        
        $recentMovements = StockMovement::with(['product', 'user'])
            ->latest()
            ->take(10)
            ->get();
            
        $topProducts = StockMovement::where('type', 'OUTGOING')
            ->select('product_id', DB::raw('SUM(quantity) as total_quantity'))
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'totalProducts',
            'todayIncoming',
            'todayOutgoing',
            'lowStockProducts',
            'recentMovements',
            'topProducts'
        ));
    }
}
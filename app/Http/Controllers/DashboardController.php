<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\IncomingInvoice;
use App\Models\OutgoingOrder;
use App\Models\StockMovement;
use App\Models\Supplier;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $data = [];

        // Общие данные для всех
        $data['totalProducts'] = Product::count();

        // Данные в зависимости от роли
        switch($user->role) {
            case 'admin':
                $data = array_merge($data, $this->getAdminData());
                break;
            case 'manager':
                $data = array_merge($data, $this->getManagerData());
                break;
            case 'storekeeper':
                $data = array_merge($data, $this->getStorekeeperData());
                break;
            case 'analyst':
                $data = array_merge($data, $this->getAnalystData());
                break;
            case 'accountant':
                $data = array_merge($data, $this->getAccountantData());
                break;
        }

        return view('dashboard.index', $data);
    }

    private function getAdminData()
    {
        return [
            'todayIncoming' => IncomingInvoice::whereDate('created_at', today())->count(),
            'todayOutgoing' => OutgoingOrder::whereDate('created_at', today())->count(),
            'lowStockProducts' => Product::whereRaw('(SELECT COALESCE(SUM(quantity), 0) FROM stock_movements WHERE product_id = products.id AND type = "INCOMING") - (SELECT COALESCE(SUM(quantity), 0) FROM stock_movements WHERE product_id = products.id AND type = "OUTGOING") <= min_stock')->count(),
            'totalSuppliers' => Supplier::count(),
            'totalCustomers' => Customer::count(),
            'recentMovements' => StockMovement::with(['product', 'user'])
                ->latest()
                ->take(10)
                ->get(),
            'topProducts' => StockMovement::where('type', 'OUTGOING')
                ->select('product_id', DB::raw('SUM(quantity) as total_quantity'))
                ->with('product')
                ->groupBy('product_id')
                ->orderByDesc('total_quantity')
                ->take(5)
                ->get(),
        ];
    }

    private function getManagerData()
    {
        return [
            'todayOutgoing' => OutgoingOrder::whereDate('created_at', today())->count(),
            'monthlySales' => OutgoingOrder::whereMonth('created_at', now()->month)
                ->sum('total_amount'),
            'topCustomers' => OutgoingOrder::select('customer_id', DB::raw('COUNT(*) as orders_count'), DB::raw('SUM(total_amount) as total'))
                ->with('customer')
                ->groupBy('customer_id')
                ->orderByDesc('total')
                ->take(5)
                ->get(),
            'recentOrders' => OutgoingOrder::with(['customer', 'user'])
                ->latest()
                ->take(10)
                ->get(),
        ];
    }

    private function getStorekeeperData()
    {
        return [
            'todayIncoming' => IncomingInvoice::whereDate('created_at', today())->count(),
            'todayOutgoing' => OutgoingOrder::whereDate('created_at', today())->count(),
            'lowStockProducts' => Product::whereRaw('(SELECT COALESCE(SUM(quantity), 0) FROM stock_movements WHERE product_id = products.id AND type = "INCOMING") - (SELECT COALESCE(SUM(quantity), 0) FROM stock_movements WHERE product_id = products.id AND type = "OUTGOING") <= min_stock')->get(),
            'pendingInventories' => \App\Models\Inventory::where('status', 'draft')->count(),
            'recentMovements' => StockMovement::with(['product', 'user'])
                ->latest()
                ->take(15)
                ->get(),
        ];
    }

    private function getAnalystData()
    {
        return [
            'totalStockValue' => Product::all()->sum(function($product) {
                return $product->current_stock * $product->purchase_price;
            }),
            'monthlyTurnover' => OutgoingOrder::whereMonth('created_at', now()->month)
                ->sum('total_amount'),
            'averageOrderValue' => OutgoingOrder::whereMonth('created_at', now()->month)
                ->avg('total_amount'),
            'topProducts' => StockMovement::where('type', 'OUTGOING')
                ->select('product_id', DB::raw('SUM(quantity) as total_quantity'))
                ->with('product')
                ->groupBy('product_id')
                ->orderByDesc('total_quantity')
                ->take(10)
                ->get(),
        ];
    }

    private function getAccountantData()
    {
        return [
            'monthlyIncome' => IncomingInvoice::whereMonth('created_at', now()->month)
                ->sum('total_amount'),
            'monthlyExpense' => OutgoingOrder::whereMonth('created_at', now()->month)
                ->sum('total_amount'),
            'pendingInvoices' => IncomingInvoice::where('status', 'draft')->count(),
            'recentTransactions' => StockMovement::with(['product', 'user'])
                ->latest()
                ->take(10)
                ->get(),
        ];
    }
}
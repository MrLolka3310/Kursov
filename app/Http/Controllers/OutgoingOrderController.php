<?php

namespace App\Http\Controllers;

use App\Models\OutgoingOrder;
use App\Models\OutgoingOrderItem;
use App\Models\Customer;
use App\Models\Product;
use App\Models\WarehouseCell;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OutgoingOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = OutgoingOrder::with(['customer', 'user', 'warehouseCell']);
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('number', 'like', "%{$search}%")
                  ->orWhereHas('customer', function($sq) use ($search) {
                      $sq->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        $orders = $query->latest()->paginate(15);
        
        return view('invoices.outgoing.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::all();
        $cells = WarehouseCell::where('is_active', true)->get();
        $products = Product::all();
        
        return view('invoices.outgoing.create', compact('customers', 'cells', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'number' => 'required|unique:outgoing_orders|max:50',
            'order_date' => 'required|date',
            'customer_id' => 'required|exists:customers,id',
            'warehouse_cell_id' => 'required|exists:warehouse_cells,id',
            'notes' => 'nullable',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.001',
        ]);

        try {
            DB::beginTransaction();

            // Проверка наличия товаров
            foreach ($validated['items'] as $item) {
                $currentStock = StockMovement::where('product_id', $item['product_id'])
                    ->where('warehouse_cell_id', $validated['warehouse_cell_id'])
                    ->select(DB::raw('SUM(CASE WHEN type = "INCOMING" THEN quantity ELSE 0 END) - SUM(CASE WHEN type = "OUTGOING" THEN quantity ELSE 0 END) as stock'))
                    ->value('stock') ?? 0;

                if ($currentStock < $item['quantity']) {
                    throw new \Exception("Недостаточно товара на складе. Товар ID: {$item['product_id']}, Доступно: {$currentStock}, Запрошено: {$item['quantity']}");
                }
            }

            $totalAmount = 0;
            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);
                $totalAmount += $item['quantity'] * $product->selling_price;
            }

            $order = OutgoingOrder::create([
                'number' => $validated['number'],
                'order_date' => $validated['order_date'],
                'customer_id' => $validated['customer_id'],
                'user_id' => Auth::id(),
                'warehouse_cell_id' => $validated['warehouse_cell_id'],
                'total_amount' => $totalAmount,
                'status' => 'shipped',
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);
                $total = $item['quantity'] * $product->selling_price;
                
                OutgoingOrderItem::create([
                    'outgoing_order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $product->selling_price,
                    'total' => $total,
                ]);

                StockMovement::create([
                    'product_id' => $item['product_id'],
                    'warehouse_cell_id' => $validated['warehouse_cell_id'],
                    'user_id' => Auth::id(),
                    'type' => 'OUTGOING',
                    'quantity' => $item['quantity'],
                    'document_type' => 'outgoing_order',
                    'document_id' => $order->id,
                ]);
            }

            DB::commit();

            return redirect()->route('outgoing-orders.show', $order)
                ->with('success', 'Расходная накладная успешно создана.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Ошибка при создании накладной: ' . $e->getMessage());
        }
    }

    public function show(OutgoingOrder $outgoingOrder)
    {
        $outgoingOrder->load(['customer', 'user', 'warehouseCell', 'items.product']);
        return view('invoices.outgoing.show', compact('outgoingOrder'));
    }

    public function destroy(OutgoingOrder $outgoingOrder)
    {
        if ($outgoingOrder->status !== 'draft') {
            return back()->with('error', 'Нельзя удалить проведенную накладную.');
        }

        try {
            DB::beginTransaction();
            
            $outgoingOrder->items()->delete();
            $outgoingOrder->stockMovements()->delete();
            $outgoingOrder->delete();
            
            DB::commit();
            
            return redirect()->route('outgoing-orders.index')
                ->with('success', 'Накладная успешно удалена.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Ошибка при удалении накладной.');
        }
    }
}
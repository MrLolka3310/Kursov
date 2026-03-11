<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\InventoryItem;
use App\Models\Product;
use App\Models\WarehouseCell;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventory::with('user');
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('number', 'like', "%{$search}%");
            });
        }
        
        $inventories = $query->latest()->paginate(15);
        
        return view('inventory.index', compact('inventories'));
    }

    public function create()
    {
        $cells = WarehouseCell::where('is_active', true)->get();
        $products = Product::all();
        
        return view('inventory.create', compact('cells', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'number' => 'required|unique:inventories|max:50',
            'inventory_date' => 'required|date',
            'notes' => 'nullable',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.warehouse_cell_id' => 'required|exists:warehouse_cells,id',
            'items.*.actual_quantity' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $inventory = Inventory::create([
                'number' => $validated['number'],
                'inventory_date' => $validated['inventory_date'],
                'user_id' => Auth::id(),
                'status' => 'completed',
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($validated['items'] as $item) {
                $expectedQuantity = StockMovement::where('product_id', $item['product_id'])
                    ->where('warehouse_cell_id', $item['warehouse_cell_id'])
                    ->select(DB::raw('SUM(CASE WHEN type = "INCOMING" THEN quantity ELSE 0 END) - SUM(CASE WHEN type = "OUTGOING" THEN quantity ELSE 0 END) as stock'))
                    ->value('stock') ?? 0;

                $difference = $item['actual_quantity'] - $expectedQuantity;

                InventoryItem::create([
                    'inventory_id' => $inventory->id,
                    'product_id' => $item['product_id'],
                    'warehouse_cell_id' => $item['warehouse_cell_id'],
                    'expected_quantity' => $expectedQuantity,
                    'actual_quantity' => $item['actual_quantity'],
                    'difference' => $difference,
                ]);

                if ($difference != 0) {
                    StockMovement::create([
                        'product_id' => $item['product_id'],
                        'warehouse_cell_id' => $item['warehouse_cell_id'],
                        'user_id' => Auth::id(),
                        'type' => 'CORRECTION',
                        'quantity' => $difference,
                        'document_type' => 'inventory',
                        'document_id' => $inventory->id,
                        'reason' => 'Корректировка по результатам инвентаризации',
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('inventory.show', $inventory)
                ->with('success', 'Инвентаризация успешно проведена.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Ошибка при проведении инвентаризации: ' . $e->getMessage());
        }
    }

    public function show(Inventory $inventory)
    {
        $inventory->load(['user', 'items.product', 'items.warehouseCell']);
        return view('inventory.show', compact('inventory'));
    }
}
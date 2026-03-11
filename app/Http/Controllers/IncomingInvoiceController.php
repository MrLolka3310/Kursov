<?php

namespace App\Http\Controllers;

use App\Models\IncomingInvoice;
use App\Models\IncomingInvoiceItem;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\WarehouseCell;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class IncomingInvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = IncomingInvoice::with(['supplier', 'user', 'warehouseCell']);
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('number', 'like', "%{$search}%")
                  ->orWhereHas('supplier', function($sq) use ($search) {
                      $sq->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        $invoices = $query->latest()->paginate(15);
        
        return view('invoices.incoming.index', compact('invoices'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $cells = WarehouseCell::where('is_active', true)->get();
        $products = Product::all();
        
        return view('invoices.incoming.create', compact('suppliers', 'cells', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'number' => 'required|unique:incoming_invoices|max:50',
            'invoice_date' => 'required|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'warehouse_cell_id' => 'required|exists:warehouse_cells,id',
            'notes' => 'nullable',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.001',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $totalAmount = 0;
            foreach ($validated['items'] as $item) {
                $totalAmount += $item['quantity'] * $item['price'];
            }

            $invoice = IncomingInvoice::create([
                'number' => $validated['number'],
                'invoice_date' => $validated['invoice_date'],
                'supplier_id' => $validated['supplier_id'],
                'user_id' => Auth::id(),
                'warehouse_cell_id' => $validated['warehouse_cell_id'],
                'total_amount' => $totalAmount,
                'status' => 'completed',
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($validated['items'] as $item) {
                $total = $item['quantity'] * $item['price'];
                
                IncomingInvoiceItem::create([
                    'incoming_invoice_id' => $invoice->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $total,
                ]);

                StockMovement::create([
                    'product_id' => $item['product_id'],
                    'warehouse_cell_id' => $validated['warehouse_cell_id'],
                    'user_id' => Auth::id(),
                    'type' => 'INCOMING',
                    'quantity' => $item['quantity'],
                    'document_type' => 'incoming_invoice',
                    'document_id' => $invoice->id,
                ]);
            }

            DB::commit();

            return redirect()->route('incoming-invoices.show', $invoice)
                ->with('success', 'Приходная накладная успешно создана.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Ошибка при создании накладной: ' . $e->getMessage());
        }
    }

    public function show(IncomingInvoice $incomingInvoice)
    {
        $incomingInvoice->load(['supplier', 'user', 'warehouseCell', 'items.product']);
        return view('invoices.incoming.show', compact('incomingInvoice'));
    }

    public function destroy(IncomingInvoice $incomingInvoice)
    {
        if ($incomingInvoice->status !== 'draft') {
            return back()->with('error', 'Нельзя удалить проведенную накладную.');
        }

        try {
            DB::beginTransaction();
            
            $incomingInvoice->items()->delete();
            $incomingInvoice->stockMovements()->delete();
            $incomingInvoice->delete();
            
            DB::commit();
            
            return redirect()->route('incoming-invoices.index')
                ->with('success', 'Накладная успешно удалена.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Ошибка при удалении накладной.');
        }
    }
}
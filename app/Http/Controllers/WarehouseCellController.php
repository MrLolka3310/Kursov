<?php

namespace App\Http\Controllers;

use App\Models\WarehouseCell;
use Illuminate\Http\Request;

class WarehouseCellController extends Controller
{
    public function index(Request $request)
    {
        // Проверяем права на просмотр
        if (!in_array(auth()->user()->role, ['admin', 'storekeeper'])) {
            abort(403, 'У вас нет доступа к этому разделу.');
        }
        
        $query = WarehouseCell::query();
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                  ->orWhere('zone', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        $cells = $query->paginate(15);
        
        return view('warehouse.cells.index', compact('cells'));
    }

    public function create()
    {
        // Проверяем права на создание
        if (!in_array(auth()->user()->role, ['admin', 'storekeeper'])) {
            abort(403, 'У вас нет доступа к этому разделу.');
        }
        
        return view('warehouse.cells.create');
    }

    public function store(Request $request)
    {
        // Проверяем права на создание
        if (!in_array(auth()->user()->role, ['admin', 'storekeeper'])) {
            abort(403, 'У вас нет доступа к этому разделу.');
        }
        
        $validated = $request->validate([
            'code' => 'required|unique:warehouse_cells|max:20',
            'zone' => 'nullable|max:50',
            'rack' => 'nullable|max:20',
            'shelf' => 'nullable|max:20',
            'description' => 'nullable',
            'max_weight' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        WarehouseCell::create($validated);

        return redirect()->route('warehouse-cells.index')
            ->with('success', 'Ячейка склада успешно создана.');
    }

    public function show(WarehouseCell $warehouseCell)
    {
        // Проверяем права на просмотр
        if (!in_array(auth()->user()->role, ['admin', 'storekeeper'])) {
            abort(403, 'У вас нет доступа к этому разделу.');
        }
        
        $warehouseCell->load(['stockMovements' => function($query) {
            $query->with(['product', 'user'])->latest()->take(20);
        }]);
        
        return view('warehouse.cells.show', compact('warehouseCell'));
    }

    public function edit(WarehouseCell $warehouseCell)
    {
        // Проверяем права на редактирование
        if (!in_array(auth()->user()->role, ['admin', 'storekeeper'])) {
            abort(403, 'У вас нет доступа к этому разделу.');
        }
        
        return view('warehouse.cells.edit', compact('warehouseCell'));
    }

    public function update(Request $request, WarehouseCell $warehouseCell)
    {
        // Проверяем права на редактирование
        if (!in_array(auth()->user()->role, ['admin', 'storekeeper'])) {
            abort(403, 'У вас нет доступа к этому разделу.');
        }
        
        $validated = $request->validate([
            'code' => 'required|max:20|unique:warehouse_cells,code,' . $warehouseCell->id,
            'zone' => 'nullable|max:50',
            'rack' => 'nullable|max:20',
            'shelf' => 'nullable|max:20',
            'description' => 'nullable',
            'max_weight' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $warehouseCell->update($validated);

        return redirect()->route('warehouse-cells.index')
            ->with('success', 'Ячейка склада успешно обновлена.');
    }

    public function destroy(WarehouseCell $warehouseCell)
    {
        // Только админ может удалять ячейки
        if (auth()->user()->role !== 'admin') {
            abort(403, 'У вас нет доступа к этому разделу.');
        }
        
        if ($warehouseCell->stockMovements()->exists()) {
            return back()->with('error', 'Невозможно удалить ячейку, так как есть связанные движения.');
        }

        $warehouseCell->delete();

        return redirect()->route('warehouse-cells.index')
            ->with('success', 'Ячейка склада успешно удалена.');
    }
}
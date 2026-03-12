<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        // Проверяем права на просмотр
        if (!in_array(auth()->user()->role, ['admin', 'manager', 'storekeeper'])) {
            abort(403, 'У вас нет доступа к этому разделу.');
        }
        
        $query = Supplier::query();
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        $suppliers = $query->paginate(15);
        
        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        // Проверяем права на создание
        if (!in_array(auth()->user()->role, ['admin', 'manager'])) {
            abort(403, 'У вас нет доступа к этому разделу.');
        }
        
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        // Проверяем права на создание
        if (!in_array(auth()->user()->role, ['admin', 'manager'])) {
            abort(403, 'У вас нет доступа к этому разделу.');
        }
        
        $validated = $request->validate([
            'name' => 'required|max:255',
            'contact_person' => 'nullable|max:100',
            'phone' => 'required|max:20',
            'email' => 'required|email|unique:suppliers|max:100',
            'address' => 'nullable',
            'inn' => 'nullable|unique:suppliers|max:12',
            'kpp' => 'nullable|max:9',
            'ogrn' => 'nullable|max:15',
            'bank_details' => 'nullable',
        ]);

        Supplier::create($validated);

        return redirect()->route('suppliers.index')
            ->with('success', 'Поставщик успешно создан.');
    }

    public function show(Supplier $supplier)
    {
        // Проверяем права на просмотр
        if (!in_array(auth()->user()->role, ['admin', 'manager', 'storekeeper'])) {
            abort(403, 'У вас нет доступа к этому разделу.');
        }
        
        $supplier->load('incomingInvoices');
        return view('suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        // Проверяем права на редактирование
        if (!in_array(auth()->user()->role, ['admin', 'manager'])) {
            abort(403, 'У вас нет доступа к этому разделу.');
        }
        
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        // Проверяем права на редактирование
        if (!in_array(auth()->user()->role, ['admin', 'manager'])) {
            abort(403, 'У вас нет доступа к этому разделу.');
        }
        
        $validated = $request->validate([
            'name' => 'required|max:255',
            'contact_person' => 'nullable|max:100',
            'phone' => 'required|max:20',
            'email' => 'required|email|max:100|unique:suppliers,email,' . $supplier->id,
            'address' => 'nullable',
            'inn' => 'nullable|max:12|unique:suppliers,inn,' . $supplier->id,
            'kpp' => 'nullable|max:9',
            'ogrn' => 'nullable|max:15',
            'bank_details' => 'nullable',
        ]);

        $supplier->update($validated);

        return redirect()->route('suppliers.index')
            ->with('success', 'Поставщик успешно обновлен.');
    }

    public function destroy(Supplier $supplier)
    {
        // Только админ может удалять поставщиков
        if (auth()->user()->role !== 'admin') {
            abort(403, 'У вас нет доступа к этому разделу.');
        }
        
        if ($supplier->incomingInvoices()->exists()) {
            return back()->with('error', 'Невозможно удалить поставщика, так как есть связанные накладные.');
        }

        $supplier->delete();

        return redirect()->route('suppliers.index')
            ->with('success', 'Поставщик успешно удален.');
    }
}
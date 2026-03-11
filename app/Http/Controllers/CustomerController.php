<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query();
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        $customers = $query->paginate(15);
        
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'contact_person' => 'nullable|max:100',
            'phone' => 'required|max:20',
            'email' => 'required|email|unique:customers|max:100',
            'address' => 'nullable',
            'inn' => 'nullable|max:12',
            'discount' => 'nullable|numeric|min:0|max:100',
            'customer_type' => 'required|in:legal,individual',
        ]);

        Customer::create($validated);

        return redirect()->route('customers.index')
            ->with('success', 'Клиент успешно создан.');
    }

    public function show(Customer $customer)
    {
        $customer->load('outgoingOrders');
        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'contact_person' => 'nullable|max:100',
            'phone' => 'required|max:20',
            'email' => 'required|email|max:100|unique:customers,email,' . $customer->id,
            'address' => 'nullable',
            'inn' => 'nullable|max:12',
            'discount' => 'nullable|numeric|min:0|max:100',
            'customer_type' => 'required|in:legal,individual',
        ]);

        $customer->update($validated);

        return redirect()->route('customers.index')
            ->with('success', 'Клиент успешно обновлен.');
    }

    public function destroy(Customer $customer)
    {
        if ($customer->outgoingOrders()->exists()) {
            return back()->with('error', 'Невозможно удалить клиента, так как есть связанные заказы.');
        }

        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Клиент успешно удален.');
    }
}
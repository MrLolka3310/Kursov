<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Все могут просматривать товары
        $query = Product::with('category');
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        
        $products = $query->paginate(15);
        $categories = Category::all();
        
        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        // Только админ и менеджер могут создавать товары
        if (!in_array(auth()->user()->role, ['admin', 'manager'])) {
            abort(403, 'У вас нет прав для создания товаров.');
        }
        
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Только админ и менеджер могут создавать товары
        if (!in_array(auth()->user()->role, ['admin', 'manager'])) {
            abort(403, 'У вас нет прав для создания товаров.');
        }
        
        $validated = $request->validate([
            'sku' => 'required|unique:products|max:100',
            'name' => 'required|max:255',
            'description' => 'nullable',
            'category_id' => 'required|exists:categories,id',
            'unit' => 'required|max:20',
            'purchase_price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'min_stock' => 'nullable|integer|min:0',
            'max_stock' => 'nullable|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Товар успешно создан.');
    }

    public function show(Product $product)
    {
        // Все могут просматривать товары
        $product->load(['category', 'stockMovements' => function($query) {
            $query->with(['user', 'warehouseCell'])->latest()->take(20);
        }]);
        
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        // Только админ и менеджер могут редактировать товары
        if (!in_array(auth()->user()->role, ['admin', 'manager'])) {
            abort(403, 'У вас нет прав для редактирования товаров.');
        }
        
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        // Только админ и менеджер могут редактировать товары
        if (!in_array(auth()->user()->role, ['admin', 'manager'])) {
            abort(403, 'У вас нет прав для редактирования товаров.');
        }
        
        $validated = $request->validate([
            'sku' => 'required|max:100|unique:products,sku,' . $product->id,
            'name' => 'required|max:255',
            'description' => 'nullable',
            'category_id' => 'required|exists:categories,id',
            'unit' => 'required|max:20',
            'purchase_price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'min_stock' => 'nullable|integer|min:0',
            'max_stock' => 'nullable|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Товар успешно обновлен.');
    }

    public function destroy(Product $product)
    {
        // Только админ может удалять товары
        if (auth()->user()->role !== 'admin') {
            abort(403, 'У вас нет прав для удаления товаров.');
        }

        if ($product->stockMovements()->exists()) {
            return back()->with('error', 'Невозможно удалить товар, так как есть связанные движения.');
        }

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Товар успешно удален.');
    }
}
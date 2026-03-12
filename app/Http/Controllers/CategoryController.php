<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        // Проверяем права на просмотр
        if (!in_array(auth()->user()->role, ['admin', 'manager'])) {
            abort(403, 'У вас нет доступа к этому разделу.');
        }
        
        $categories = Category::with('parent')->paginate(15);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        // Проверяем права на создание
        if (!in_array(auth()->user()->role, ['admin', 'manager'])) {
            abort(403, 'У вас нет доступа к этому разделу.');
        }
        
        $categories = Category::all();
        return view('categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Проверяем права на создание
        if (!in_array(auth()->user()->role, ['admin', 'manager'])) {
            abort(403, 'У вас нет доступа к этому разделу.');
        }
        
        $validated = $request->validate([
            'name' => 'required|max:100',
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        Category::create($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Категория успешно создана.');
    }

    public function edit(Category $category)
    {
        // Проверяем права на редактирование
        if (!in_array(auth()->user()->role, ['admin', 'manager'])) {
            abort(403, 'У вас нет доступа к этому разделу.');
        }
        
        $categories = Category::where('id', '!=', $category->id)->get();
        return view('categories.edit', compact('category', 'categories'));
    }

    public function update(Request $request, Category $category)
    {
        // Проверяем права на редактирование
        if (!in_array(auth()->user()->role, ['admin', 'manager'])) {
            abort(403, 'У вас нет доступа к этому разделу.');
        }
        
        $validated = $request->validate([
            'name' => 'required|max:100',
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $category->update($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Категория успешно обновлена.');
    }

    public function destroy(Category $category)
    {
        // Только админ может удалять категории
        if (auth()->user()->role !== 'admin') {
            abort(403, 'У вас нет доступа к этому разделу.');
        }
        
        if ($category->products()->exists()) {
            return back()->with('error', 'Невозможно удалить категорию, так как есть связанные товары.');
        }

        if ($category->children()->exists()) {
            return back()->with('error', 'Невозможно удалить категорию, так как есть дочерние категории.');
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Категория успешно удалена.');
    }
}
@extends('layouts.app')

@section('title', 'Новый товар')

@section('page-title')
    <i class="fas fa-plus"></i>
    Новый товар
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div>
                <i class="fas fa-box"></i>
                Создание товара
            </div>
            <a href="{{ route('products.index') }}" class="btn btn-outline btn-sm">
                <i class="fas fa-arrow-left"></i>
                Назад
            </a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-barcode"></i> Артикул *</label>
                        <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror" value="{{ old('sku') }}" required>
                        @error('sku')
                            <small style="color: var(--danger-color);">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label><i class="fas fa-tag"></i> Наименование *</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')
                            <small style="color: var(--danger-color);">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-folder"></i> Категория *</label>
                        <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                            <option value="">Выберите категорию</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <small style="color: var(--danger-color);">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label><i class="fas fa-balance-scale"></i> Единица измерения *</label>
                        <select name="unit" class="form-control @error('unit') is-invalid @enderror" required>
                            <option value="шт" {{ old('unit') == 'шт' ? 'selected' : '' }}>шт</option>
                            <option value="кг" {{ old('unit') == 'кг' ? 'selected' : '' }}>кг</option>
                            <option value="л" {{ old('unit') == 'л' ? 'selected' : '' }}>л</option>
                            <option value="м" {{ old('unit') == 'м' ? 'selected' : '' }}>м</option>
                            <option value="уп" {{ old('unit') == 'уп' ? 'selected' : '' }}>упаковка</option>
                        </select>
                        @error('unit')
                            <small style="color: var(--danger-color);">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-money-bill"></i> Закупочная цена</label>
                        <input type="number" name="purchase_price" class="form-control @error('purchase_price') is-invalid @enderror" value="{{ old('purchase_price') }}" step="0.01" min="0">
                        @error('purchase_price')
                            <small style="color: var(--danger-color);">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label><i class="fas fa-money-bill-wave"></i> Цена продажи</label>
                        <input type="number" name="selling_price" class="form-control @error('selling_price') is-invalid @enderror" value="{{ old('selling_price') }}" step="0.01" min="0">
                        @error('selling_price')
                            <small style="color: var(--danger-color);">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-arrow-down"></i> Минимальный остаток</label>
                        <input type="number" name="min_stock" class="form-control @error('min_stock') is-invalid @enderror" value="{{ old('min_stock', 0) }}" step="0.001" min="0">
                        @error('min_stock')
                            <small style="color: var(--danger-color);">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label><i class="fas fa-arrow-up"></i> Максимальный остаток</label>
                        <input type="number" name="max_stock" class="form-control @error('max_stock') is-invalid @enderror" value="{{ old('max_stock') }}" step="0.001" min="0">
                        @error('max_stock')
                            <small style="color: var(--danger-color);">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-image"></i> Изображение</label>
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                    @error('image')
                        <small style="color: var(--danger-color);">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-align-left"></i> Описание</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description') }}</textarea>
                    @error('description')
                        <small style="color: var(--danger-color);">{{ $message }}</small>
                    @enderror
                </div>
                
                <hr>
                
                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i>
                        Сохранить товар
                    </button>
                    <a href="{{ route('products.index') }}" class="btn btn-outline">
                        <i class="fas fa-times"></i>
                        Отмена
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
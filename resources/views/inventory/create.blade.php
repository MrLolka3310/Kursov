@extends('layouts.app')

@section('title', 'Новая инвентаризация')

@section('page-title')
    <i class="fas fa-plus"></i>
    Новая инвентаризация
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div>
                <i class="fas fa-clipboard-list"></i>
                Проведение инвентаризации
            </div>
            <a href="{{ route('inventory.index') }}" class="btn btn-outline btn-sm">
                <i class="fas fa-arrow-left"></i>
                Назад
            </a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('inventory.store') }}" id="inventoryForm">
                @csrf
                
                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-hashtag"></i> Номер документа *</label>
                        <input type="text" name="number" class="form-control @error('number') is-invalid @enderror" value="{{ old('number', 'INV-' . date('Ymd')) }}" required>
                        @error('number')
                            <small style="color: var(--danger-color);">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label><i class="fas fa-calendar"></i> Дата *</label>
                        <input type="date" name="inventory_date" class="form-control @error('inventory_date') is-invalid @enderror" value="{{ old('inventory_date', date('Y-m-d')) }}" required>
                        @error('inventory_date')
                            <small style="color: var(--danger-color);">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-sticky-note"></i> Примечание</label>
                    <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes') }}</textarea>
                    @error('notes')
                        <small style="color: var(--danger-color);">{{ $message }}</small>
                    @enderror
                </div>
                
                <hr>
                
                <h4 style="margin-bottom: 20px;">Товары для инвентаризации</h4>
                
                <div id="items-container">
                    <!-- Здесь будут динамически добавляться товары -->
                </div>
                
                <button type="button" class="btn btn-outline" id="add-item" style="margin-bottom: 20px;">
                    <i class="fas fa-plus"></i>
                    Добавить товар
                </button>
                
                <hr>
                
                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i>
                        Провести инвентаризацию
                    </button>
                    <a href="{{ route('inventory.index') }}" class="btn btn-outline">
                        <i class="fas fa-times"></i>
                        Отмена
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .item-row {
        background: #f8f9fa;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 5px;
        border-left: 3px solid var(--warning-color);
        animation: slideInRight 0.3s;
    }
    
    .item-row .remove-item {
        margin-top: 24px;
    }
    
    .difference-positive {
        color: var(--success-color);
        font-weight: bold;
    }
    
    .difference-negative {
        color: var(--danger-color);
        font-weight: bold;
    }
</style>
@endpush

@push('scripts')
<script>
    let itemIndex = 0;
    const products = @json($products);
    const cells = @json($cells);
    
    document.getElementById('add-item').addEventListener('click', function() {
        const container = document.getElementById('items-container');
        const template = `
            <div class="item-row" data-index="${itemIndex}">
                <div class="form-row">
                    <div class="form-group" style="flex: 2;">
                        <label>Товар *</label>
                        <select name="items[${itemIndex}][product_id]" class="form-control product-select" required>
                            <option value="">Выберите товар</option>
                            ${products.map(p => `<option value="${p.id}">${p.name} (${p.sku})</option>`).join('')}
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Ячейка *</label>
                        <select name="items[${itemIndex}][warehouse_cell_id]" class="form-control cell-select" required>
                            <option value="">Выберите ячейку</option>
                            ${cells.map(c => `<option value="${c.id}">${c.code}</option>`).join('')}
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Ожидаемое кол-во</label>
                        <input type="text" class="form-control expected-quantity" readonly>
                    </div>
                    <div class="form-group">
                        <label>Фактическое кол-во *</label>
                        <input type="number" name="items[${itemIndex}][actual_quantity]" class="form-control actual-quantity" step="0.001" min="0" required>
                    </div>
                    <div class="form-group">
                        <label>Расхождение</label>
                        <input type="text" class="form-control difference" readonly>
                    </div>
                    <div class="form-group remove-item">
                        <label>&nbsp;</label>
                        <button type="button" class="btn btn-danger btn-sm" onclick="removeItem(this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', template);
        
        // Добавляем обработчики для нового элемента
        const row = container.lastElementChild;
        const productSelect = row.querySelector('.product-select');
        const cellSelect = row.querySelector('.cell-select');
        const actualInput = row.querySelector('.actual-quantity');
        const expectedInput = row.querySelector('.expected-quantity');
        const differenceInput = row.querySelector('.difference');
        
        async function updateExpectedQuantity() {
            const productId = productSelect.value;
            const cellId = cellSelect.value;
            
            if (productId && cellId) {
                try {
                    // Здесь должен быть AJAX запрос к API для получения текущего остатка
                    // Для демо используем заглушку
                    const expected = Math.floor(Math.random() * 100);
                    expectedInput.value = expected;
                    calculateDifference();
                } catch (error) {
                    console.error('Error fetching stock:', error);
                }
            }
        }
        
        function calculateDifference() {
            const expected = parseFloat(expectedInput.value) || 0;
            const actual = parseFloat(actualInput.value) || 0;
            const difference = actual - expected;
            differenceInput.value = difference.toFixed(3);
            
            if (difference > 0) {
                differenceInput.classList.add('difference-positive');
                differenceInput.classList.remove('difference-negative');
            } else if (difference < 0) {
                differenceInput.classList.add('difference-negative');
                differenceInput.classList.remove('difference-positive');
            } else {
                differenceInput.classList.remove('difference-positive', 'difference-negative');
            }
        }
        
        productSelect.addEventListener('change', updateExpectedQuantity);
        cellSelect.addEventListener('change', updateExpectedQuantity);
        actualInput.addEventListener('input', calculateDifference);
        
        itemIndex++;
    });
    
    function removeItem(button) {
        if (confirm('Удалить товар из инвентаризации?')) {
            button.closest('.item-row').remove();
        }
    }
    
    // Добавляем первый товар автоматически
    document.getElementById('add-item').click();
</script>
@endpush
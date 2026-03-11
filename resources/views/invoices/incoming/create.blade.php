@extends('layouts.app')

@section('title', 'Новая приходная накладная')

@section('page-title')
    <i class="fas fa-plus"></i>
    Новая приходная накладная
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div>
                <i class="fas fa-truck"></i>
                Создание приходной накладной
            </div>
            <a href="{{ route('incoming-invoices.index') }}" class="btn btn-outline btn-sm">
                <i class="fas fa-arrow-left"></i>
                Назад
            </a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('incoming-invoices.store') }}" id="invoiceForm">
                @csrf
                
                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-hashtag"></i> Номер накладной *</label>
                        <input type="text" name="number" class="form-control @error('number') is-invalid @enderror" value="{{ old('number') }}" required>
                        @error('number')
                            <small style="color: var(--danger-color);">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label><i class="fas fa-calendar"></i> Дата *</label>
                        <input type="date" name="invoice_date" class="form-control @error('invoice_date') is-invalid @enderror" value="{{ old('invoice_date', date('Y-m-d')) }}" required>
                        @error('invoice_date')
                            <small style="color: var(--danger-color);">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-truck"></i> Поставщик *</label>
                        <select name="supplier_id" class="form-control @error('supplier_id') is-invalid @enderror" required>
                            <option value="">Выберите поставщика</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <small style="color: var(--danger-color);">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label><i class="fas fa-warehouse"></i> Ячейка склада *</label>
                        <select name="warehouse_cell_id" class="form-control @error('warehouse_cell_id') is-invalid @enderror" required>
                            <option value="">Выберите ячейку</option>
                            @foreach($cells as $cell)
                                <option value="{{ $cell->id }}" {{ old('warehouse_cell_id') == $cell->id ? 'selected' : '' }}>
                                    {{ $cell->code }} ({{ $cell->zone ?? 'Без зоны' }})
                                </option>
                            @endforeach
                        </select>
                        @error('warehouse_cell_id')
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
                
                <h4 style="margin-bottom: 20px;">Товары в накладной</h4>
                
                <div id="items-container">
                    <!-- Здесь будут динамически добавляться товары -->
                </div>
                
                <button type="button" class="btn btn-outline" id="add-item" style="margin-bottom: 20px;">
                    <i class="fas fa-plus"></i>
                    Добавить товар
                </button>
                
                <div class="form-group">
                    <label>Общая сумма:</label>
                    <h3 id="total-amount">0.00 ₽</h3>
                </div>
                
                <hr>
                
                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i>
                        Сохранить накладную
                    </button>
                    <a href="{{ route('incoming-invoices.index') }}" class="btn btn-outline">
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
        border-left: 3px solid var(--secondary-color);
        animation: slideInRight 0.3s;
    }
    
    .item-row .remove-item {
        margin-top: 24px;
    }
    
    .is-invalid {
        border-color: var(--danger-color) !important;
    }
</style>
@endpush

@push('scripts')
<script>
    let itemIndex = 0;
    const products = @json($products);
    
    document.getElementById('add-item').addEventListener('click', function() {
        const container = document.getElementById('items-container');
        const template = `
            <div class="item-row" data-index="${itemIndex}">
                <div class="form-row">
                    <div class="form-group" style="flex: 2;">
                        <label>Товар *</label>
                        <select name="items[${itemIndex}][product_id]" class="form-control product-select" required>
                            <option value="">Выберите товар</option>
                            ${products.map(p => `<option value="${p.id}" data-price="${p.purchase_price || 0}">${p.name} (${p.sku})</option>`).join('')}
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Количество *</label>
                        <input type="number" name="items[${itemIndex}][quantity]" class="form-control quantity" step="0.001" min="0.001" required>
                    </div>
                    <div class="form-group">
                        <label>Цена *</label>
                        <input type="number" name="items[${itemIndex}][price]" class="form-control price" step="0.01" min="0" required>
                    </div>
                    <div class="form-group">
                        <label>Сумма</label>
                        <input type="text" class="form-control item-total" readonly>
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
        const select = row.querySelector('.product-select');
        const quantity = row.querySelector('.quantity');
        const price = row.querySelector('.price');
        
        select.addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            const purchasePrice = selected.dataset.price;
            if (purchasePrice && purchasePrice > 0) {
                price.value = purchasePrice;
            }
            calculateItemTotal(row);
            calculateTotal();
        });
        
        quantity.addEventListener('input', function() {
            calculateItemTotal(row);
            calculateTotal();
        });
        
        price.addEventListener('input', function() {
            calculateItemTotal(row);
            calculateTotal();
        });
        
        itemIndex++;
    });
    
    function calculateItemTotal(row) {
        const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
        const price = parseFloat(row.querySelector('.price').value) || 0;
        const total = quantity * price;
        row.querySelector('.item-total').value = total.toFixed(2);
    }
    
    function calculateTotal() {
        let total = 0;
        document.querySelectorAll('.item-total').forEach(input => {
            total += parseFloat(input.value) || 0;
        });
        document.getElementById('total-amount').textContent = total.toFixed(2) + ' ₽';
    }
    
    function removeItem(button) {
        if (confirm('Удалить товар из накладной?')) {
            button.closest('.item-row').remove();
            calculateTotal();
        }
    }
    
    // Добавляем первый товар автоматически
    document.getElementById('add-item').click();
</script>
@endpush
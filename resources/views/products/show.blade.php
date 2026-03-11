@extends('layouts.app')

@section('title', $product->name)

@section('page-title')
    <i class="fas fa-box"></i>
    {{ $product->name }}
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div>
                <i class="fas fa-info-circle"></i>
                Детали товара
            </div>
            <div>
                <a href="{{ route('products.edit', $product) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-edit"></i>
                    Редактировать
                </a>
                <a href="{{ route('products.index') }}" class="btn btn-outline btn-sm">
                    <i class="fas fa-arrow-left"></i>
                    Назад
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="product-details">
                <div class="product-image">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    @else
                        <div style="padding: 50px; background: #f0f0f0; text-align: center;">
                            <i class="fas fa-image" style="font-size: 48px; color: #999;"></i>
                            <p>Нет изображения</p>
                        </div>
                    @endif
                </div>
                
                <div class="product-info">
                    <div class="info-item">
                        <div class="label">Артикул</div>
                        <div class="value">{{ $product->sku }}</div>
                    </div>
                    
                    <div class="info-item">
                        <div class="label">Категория</div>
                        <div class="value">{{ $product->category->name ?? 'N/A' }}</div>
                    </div>
                    
                    <div class="info-item">
                        <div class="label">Единица измерения</div>
                        <div class="value">{{ $product->unit }}</div>
                    </div>
                    
                    <div class="info-item">
                        <div class="label">Закупочная цена</div>
                        <div class="value">{{ number_format($product->purchase_price, 2, ',', ' ') }} ₽</div>
                    </div>
                    
                    <div class="info-item">
                        <div class="label">Цена продажи</div>
                        <div class="value">{{ number_format($product->selling_price, 2, ',', ' ') }} ₽</div>
                    </div>
                    
                    <div class="info-item">
                        <div class="label">Текущий остаток</div>
                        <div class="value">
                            @php
                                $stock = $product->current_stock;
                                $stockClass = $stock <= $product->min_stock ? 'danger' : 'success';
                            @endphp
                            <span class="badge badge-{{ $stockClass }}" style="font-size: 1rem;">
                                {{ number_format($stock, 3, ',', ' ') }} {{ $product->unit }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="label">Минимальный остаток</div>
                        <div class="value">{{ number_format($product->min_stock, 3, ',', ' ') }} {{ $product->unit }}</div>
                    </div>
                    
                    <div class="info-item">
                        <div class="label">Максимальный остаток</div>
                        <div class="value">{{ number_format($product->max_stock, 3, ',', ' ') }} {{ $product->unit }}</div>
                    </div>
                </div>
            </div>
            
            @if($product->description)
                <div style="margin-top: 30px;">
                    <h4>Описание</h4>
                    <p>{{ $product->description }}</p>
                </div>
            @endif
            
            <hr>
            
            <h4 style="margin-bottom: 15px;">История движений</h4>
            
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Дата</th>
                            <th>Тип</th>
                            <th>Количество</th>
                            <th>Ячейка</th>
                            <th>Документ</th>
                            <th>Пользователь</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($product->stockMovements as $movement)
                            <tr>
                                <td>{{ $movement->created_at->format('d.m.Y H:i') }}</td>
                                <td>
                                    @switch($movement->type)
                                        @case('INCOMING')
                                            <span class="badge badge-success">Приход</span>
                                            @break
                                        @case('OUTGOING')
                                            <span class="badge badge-danger">Расход</span>
                                            @break
                                        @case('CORRECTION')
                                            <span class="badge badge-warning">Коррекция</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>{{ number_format($movement->quantity, 3, ',', ' ') }}</td>
                                <td>{{ $movement->warehouseCell->code ?? 'N/A' }}</td>
                                <td>
                                    @if($movement->document_type == 'incoming_invoice')
                                        <a href="{{ route('incoming-invoices.show', $movement->document_id) }}">Накладная #{{ $movement->document_id }}</a>
                                    @elseif($movement->document_type == 'outgoing_order')
                                        <a href="{{ route('outgoing-orders.show', $movement->document_id) }}">Заказ #{{ $movement->document_id }}</a>
                                    @else
                                        {{ $movement->document_type }} #{{ $movement->document_id }}
                                    @endif
                                </td>
                                <td>{{ $movement->user->name ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center;">Нет движений</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
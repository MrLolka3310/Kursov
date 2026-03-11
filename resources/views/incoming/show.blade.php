@extends('layouts.app')

@section('title', 'Просмотр накладной')

@section('page-title')
    <i class="fas fa-file-invoice"></i>
    Накладная №{{ $incomingInvoice->number }}
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div>
                <i class="fas fa-info-circle"></i>
                Детали накладной
            </div>
            <div>
                <a href="{{ route('incoming-invoices.index') }}" class="btn btn-outline btn-sm">
                    <i class="fas fa-arrow-left"></i>
                    Назад
                </a>
            </div>
        </div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">
                <div class="info-item">
                    <div class="label">Номер накладной</div>
                    <div class="value">{{ $incomingInvoice->number }}</div>
                </div>
                <div class="info-item">
                    <div class="label">Дата</div>
                    <div class="value">{{ $incomingInvoice->invoice_date->format('d.m.Y') }}</div>
                </div>
                <div class="info-item">
                    <div class="label">Статус</div>
                    <div class="value">
                        @switch($incomingInvoice->status)
                            @case('draft')
                                <span class="badge badge-warning">Черновик</span>
                                @break
                            @case('completed')
                                <span class="badge badge-success">Проведен</span>
                                @break
                            @case('cancelled')
                                <span class="badge badge-danger">Отменен</span>
                                @break
                        @endswitch
                    </div>
                </div>
                <div class="info-item">
                    <div class="label">Поставщик</div>
                    <div class="value">{{ $incomingInvoice->supplier->name ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="label">Ячейка склада</div>
                    <div class="value">{{ $incomingInvoice->warehouseCell->code ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="label">Создал</div>
                    <div class="value">{{ $incomingInvoice->user->name ?? 'N/A' }}</div>
                </div>
            </div>
            
            @if($incomingInvoice->notes)
                <div style="margin-bottom: 30px;">
                    <strong>Примечание:</strong>
                    <p>{{ $incomingInvoice->notes }}</p>
                </div>
            @endif
            
            <h4 style="margin-bottom: 15px;">Товары в накладной</h4>
            
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th>Товар</th>
                            <th>Артикул</th>
                            <th>Количество</th>
                            <th>Цена</th>
                            <th>Сумма</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($incomingInvoice->items as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->product->name ?? 'N/A' }}</td>
                                <td>{{ $item->product->sku ?? 'N/A' }}</td>
                                <td>{{ number_format($item->quantity, 3, ',', ' ') }}</td>
                                <td>{{ number_format($item->price, 2, ',', ' ') }} ₽</td>
                                <td>{{ number_format($item->total, 2, ',', ' ') }} ₽</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5" style="text-align: right;">Итого:</th>
                            <th>{{ number_format($incomingInvoice->total_amount, 2, ',', ' ') }} ₽</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
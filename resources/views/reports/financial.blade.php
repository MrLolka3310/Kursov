@extends('layouts.app')

@section('title', 'Финансовый отчет')

@section('page-title')
    <i class="fas fa-chart-pie"></i>
    Финансовый отчет
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div>
                <i class="fas fa-filter"></i>
                Фильтр отчета
            </div>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('reports.financial') }}" class="form-row">
                <div class="form-group">
                    <label>Начальная дата</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $startDate instanceof \Carbon\Carbon ? $startDate->format('Y-m-d') : $startDate }}">
                </div>
                <div class="form-group">
                    <label>Конечная дата</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $endDate instanceof \Carbon\Carbon ? $endDate->format('Y-m-d') : $endDate }}">
                </div>
                <div class="form-group">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-search"></i>
                        Применить
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon success">
                <i class="fas fa-arrow-down"></i>
            </div>
            <div class="stat-info">
                <h3>Поступления</h3>
                <div class="stat-number">{{ number_format($incomingTotal, 2, ',', ' ') }} ₽</div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon danger">
                <i class="fas fa-arrow-up"></i>
            </div>
            <div class="stat-info">
                <h3>Реализация</h3>
                <div class="stat-number">{{ number_format($outgoingTotal, 2, ',', ' ') }} ₽</div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon {{ $profit >= 0 ? 'success' : 'danger' }}">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-info">
                <h3>Прибыль</h3>
                <div class="stat-number">{{ number_format($profit, 2, ',', ' ') }} ₽</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div>
                <i class="fas fa-chart-bar"></i>
                График финансовых показателей
            </div>
        </div>
        <div class="card-body">
            <div style="height: 300px; display: flex; align-items: flex-end; gap: 20px; padding: 20px 0;">
                <div style="flex: 1; text-align: center;">
                    <div style="background: var(--success-color); height: {{ $incomingTotal > 0 ? min(200, ($incomingTotal / max($incomingTotal, $outgoingTotal) * 200)) : 0 }}px; width: 100%; border-radius: 5px 5px 0 0;"></div>
                    <div style="margin-top: 10px;">Поступления</div>
                    <div><strong>{{ number_format($incomingTotal, 0, ',', ' ') }} ₽</strong></div>
                </div>
                <div style="flex: 1; text-align: center;">
                    <div style="background: var(--danger-color); height: {{ $outgoingTotal > 0 ? min(200, ($outgoingTotal / max($incomingTotal, $outgoingTotal) * 200)) : 0 }}px; width: 100%; border-radius: 5px 5px 0 0;"></div>
                    <div style="margin-top: 10px;">Реализация</div>
                    <div><strong>{{ number_format($outgoingTotal, 0, ',', ' ') }} ₽</strong></div>
                </div>
                <div style="flex: 1; text-align: center;">
                    <div style="background: {{ $profit >= 0 ? 'var(--success-color)' : 'var(--danger-color)' }}; height: {{ abs($profit) > 0 ? min(200, (abs($profit) / max($incomingTotal, $outgoingTotal, abs($profit)) * 200)) : 0 }}px; width: 100%; border-radius: 5px 5px 0 0;"></div>
                    <div style="margin-top: 10px;">Прибыль</div>
                    <div><strong>{{ number_format($profit, 0, ',', ' ') }} ₽</strong></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div>
                <i class="fas fa-calculator"></i>
                Детальный расчет
            </div>
        </div>
        <div class="card-body">
            <table style="width: 100%; border-collapse: collapse;">
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 10px;"><strong>Поступления (закупка товаров)</strong></td>
                    <td style="padding: 10px; text-align: right;">{{ number_format($incomingTotal, 2, ',', ' ') }} ₽</td>
                </tr>
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 10px;"><strong>Реализация (продажи)</strong></td>
                    <td style="padding: 10px; text-align: right;">{{ number_format($outgoingTotal, 2, ',', ' ') }} ₽</td>
                </tr>
                <tr>
                    <td style="padding: 10px;"><strong>Итоговая прибыль</strong></td>
                    <td style="padding: 10px; text-align: right; color: {{ $profit >= 0 ? 'var(--success-color)' : 'var(--danger-color)' }}; font-size: 1.2rem;">
                        <strong>{{ number_format($profit, 2, ',', ' ') }} ₽</strong>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@endsection
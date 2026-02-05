@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Расход товара</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="/expenses">
            @csrf

            <div class="form-group">
                <label for="warehouse_id">Выберите склад:</label>
                <select name="warehouse_id" id="warehouse_id" class="form-control" required>
                    <option value="">-- Выберите склад --</option>
                    @foreach($warehouses as $w)
                    <option value="{{ $w->id }}">{{ $w->name }}</option>
                    @endforeach
                </select>
            </div>

            <h4>Товары</h4>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Название товара</th>
                            <th>Количество</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $p)
                        <tr>
                            <td>{{ $p->name }}</td>
                            <td>
                                <input type="number"
                                    name="products[{{ $p->id }}]"
                                    value="0"
                                    min="0"
                                    class="form-control"
                                    placeholder="0">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-danger">Списать</button>
                <a href="/expenses" class="btn btn-secondary">Отмена</a>
            </div>
        </form>
    </div>
</div>
@endsection

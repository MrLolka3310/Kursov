@extends('layouts.app')

@section('content')
<h3>Приход товара</h3>

<form method="POST" action="/incomes">
@csrf

<select name="warehouse_id">
@foreach($warehouses as $w)
<option value="{{ $w->id }}">{{ $w->name }}</option>
@endforeach
</select>

<select name="supplier_id">
@foreach($suppliers as $s)
<option value="{{ $s->id }}">{{ $s->name }}</option>
@endforeach
</select>

<h4>Товары</h4>

@foreach($products as $p)
<div>
    {{ $p->name }}
    <input type="number" name="products[{{ $p->id }}]" value="0" min="0">
</div>
@endforeach

<button>Сохранить приход</button>
</form>
@endsection

@extends('layouts.app')

@section('content')
<h3>Остатки на складах</h3>

<table>
<tr>
    <th>Склад</th>
    <th>Товар</th>
    <th>Количество</th>
</tr>

@foreach($stocks as $s)
<tr>
    <td>{{ $s->warehouse->name }}</td>
    <td>{{ $s->product->name }}</td>
    <td>{{ $s->quantity }}</td>
</tr>
@endforeach
</table>
@endsection

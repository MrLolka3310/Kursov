@extends('layouts.app')

@section('content')
<h3>Товары</h3>

<a href="/products/create">Добавить товар</a>

<table>
<tr>
    <th>Название</th>
    <th>Категория</th>
    <th>Цена</th>
    <th>Ед.</th>
    <th></th>
</tr>

@foreach($products as $p)
<tr>
    <td>{{ $p->name }}</td>
    <td>{{ $p->category->name }}</td>
    <td>{{ $p->price }}</td>
    <td>{{ $p->unit }}</td>
    <td>
        <a href="/products/{{ $p->id }}/edit">✏️</a>
        <form method="POST" action="/products/{{ $p->id }}" style="display:inline">
            @csrf @method('DELETE')
            <button>🗑️</button>
        </form>
    </td>
</tr>
@endforeach
</table>
@endsection

@extends('layouts.app')

@section('content')
<h3>Склады</h3>

<a href="/warehouses/create">Добавить склад</a>

<table>
@foreach($warehouses as $w)
<tr>
    <td>{{ $w->name }}</td>
    <td>{{ $w->address }}</td>
    <td>
        <a href="/warehouses/{{ $w->id }}/edit">Редактировать</a>
        <form method="POST" action="/warehouses/{{ $w->id }}" style="display:inline">
            @csrf @method('DELETE')
            <button>Удалить</button>
        </form>
    </td>
</tr>
@endforeach
</table>
@endsection

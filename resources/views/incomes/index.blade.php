@extends('layouts.app')

@section('content')
<h3>Приходы</h3>

<a href="/incomes/create">Новый приход</a>

<table>
@foreach($incomes as $i)
<tr>
    <td>{{ $i->created_at }}</td>
    <td>{{ $i->warehouse->name }}</td>
    <td>{{ $i->supplier->name }}</td>
    <td>
        <a href="/incomes/{{ $i->id }}">Просмотр</a>
    </td>
</tr>
@endforeach
</table>
@endsection

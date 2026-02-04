@extends('layouts.app')

@section('content')
<h3>Расходы</h3>

<a href="/expenses/create">Новый расход</a>

<table>
@foreach($expenses as $e)
<tr>
    <td>{{ $e->created_at }}</td>
    <td>{{ $e->warehouse->name }}</td>
    <td>
        <a href="/expenses/{{ $e->id }}">Просмотр</a>
    </td>
</tr>
@endforeach
</table>
@endsection

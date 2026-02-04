@extends('layouts.app')

@section('content')
<h3>Движение товаров</h3>

<h4>Приход</h4>
<table>
@foreach($incomes as $i)
<tr>
    <td>{{ $i->created_at }}</td>
    <td>{{ $i->warehouse->name }}</td>
    <td>Приход</td>
</tr>
@endforeach
</table>

<h4>Расход</h4>
<table>
@foreach($expenses as $e)
<tr>
    <td>{{ $e->created_at }}</td>
    <td>{{ $e->warehouse->name }}</td>
    <td>Расход</td>
</tr>
@endforeach
</table>
@endsection

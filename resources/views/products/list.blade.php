@extends('layouts.app')

@section('content')
<h3>Список товаров</h3>

<table>
@foreach($products as $p)
<tr>
    <td>{{ $p->name }}</td>
    <td>{{ $p->category->name }}</td>
    <td>{{ $p->unit }}</td>
</tr>
@endforeach
</table>
@endsection

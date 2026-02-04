@extends('layouts.app')

@section('content')
<h3>Детали расхода</h3>

<table>
@foreach($expense->items as $item)
<tr>
    <td>{{ $item->product->name }}</td>
    <td>{{ $item->quantity }}</td>
</tr>
@endforeach
</table>
@endsection

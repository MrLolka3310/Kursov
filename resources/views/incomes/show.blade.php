@extends('layouts.app')

@section('content')
<h3>Детали прихода</h3>

<table>
@foreach($income->items as $item)
<tr>
    <td>{{ $item->product->name }}</td>
    <td>{{ $item->quantity }}</td>
</tr>
@endforeach
</table>
@endsection

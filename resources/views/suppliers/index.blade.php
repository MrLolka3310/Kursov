@extends('layouts.app')

@section('content')
<h3>Поставщики</h3>

<a href="/suppliers/create">Добавить</a>

<table>
@foreach($suppliers as $s)
<tr>
    <td>{{ $s->name }}</td>
    <td>{{ $s->phone }}</td>
    <td>{{ $s->email }}</td>
    <td>
        <a href="/suppliers/{{ $s->id }}/edit">✏️</a>
        <form method="POST" action="/suppliers/{{ $s->id }}" style="display:inline">
            @csrf @method('DELETE')
            <button>🗑️</button>
        </form>
    </td>
</tr>
@endforeach
</table>
@endsection

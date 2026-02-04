@extends('layouts.app')

@section('content')
<h3>Категории</h3>

<a href="/categories/create">Добавить</a>

<table>
@foreach($categories as $c)
<tr>
    <td>{{ $c->name }}</td>
    <td>
        <a href="/categories/{{ $c->id }}/edit">Редактировать</a>
        <form method="POST" action="/categories/{{ $c->id }}">
            @csrf @method('DELETE')
            <button>Удалить</button>
        </form>
    </td>
</tr>
@endforeach
</table>
@endsection

@extends('layouts.app')

@section('content')
<h3>Редактирование склада</h3>

<form method="POST" action="/warehouses/{{ $warehouse->id }}">
    @csrf
    @method('PUT')
    <input name="name" value="{{ $warehouse->name }}" placeholder="Название"><br>
    <input name="address" value="{{ $warehouse->address }}" placeholder="Адрес"><br>
    <button>Сохранить</button>
</form>
@endsection

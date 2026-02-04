@extends('layouts.app')

@section('content')
<h3>Редактирование поставщика</h3>

<form method="POST" action="/suppliers/{{ $supplier->id }}">
    @csrf
    @method('PUT')
    <input name="name" value="{{ $supplier->name }}" placeholder="Название"><br>
    <input name="phone" value="{{ $supplier->phone }}" placeholder="Телефон"><br>
    <input name="email" value="{{ $supplier->email }}" placeholder="Email"><br>
    <button>Сохранить</button>
</form>
@endsection

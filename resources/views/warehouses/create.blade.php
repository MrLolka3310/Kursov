@extends('layouts.app')

@section('content')
<h3>Новый склад</h3>

<form method="POST" action="/warehouses">
    @csrf
    <input name="name" placeholder="Название"><br>
    <input name="address" placeholder="Адрес"><br>
    <button>Сохранить</button>
</form>
@endsection

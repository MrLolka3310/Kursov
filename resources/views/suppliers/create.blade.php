@extends('layouts.app')

@section('content')
<h3>Новый поставщик</h3>

<form method="POST" action="/suppliers">
    @csrf
    <input name="name" placeholder="Название"><br>
    <input name="phone" placeholder="Телефон"><br>
    <input name="email" placeholder="Email"><br>
    <button>Сохранить</button>
</form>
@endsection

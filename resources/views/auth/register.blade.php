@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
<h3>Регистрация</h3>

<form method="POST" action="/register">
    @csrf

    <input name="name" placeholder="Имя"><br>
    <input name="email" type="email" placeholder="Email"><br>
    <input name="password" type="password" placeholder="Пароль"><br>
    <input name="password_confirmation" type="password" placeholder="Повтор пароля"><br>

    <button>Зарегистрироваться</button>
</form>
@endsection

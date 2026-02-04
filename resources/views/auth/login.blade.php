@extends('layouts.app')

@section('title', 'Вход')

@section('content')
<h3>Вход</h3>

<form method="POST" action="/login">
    @csrf

    <input type="email" name="email" placeholder="Email"><br>
    <input type="password" name="password" placeholder="Пароль"><br>

    <button>Войти</button>
</form>

<a href="/register">Регистрация</a>
@endsection

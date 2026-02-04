@extends('layouts.app')

@section('content')
<h3>Новая категория</h3>

<form method="POST" action="/categories">
    @csrf
    <input name="name" placeholder="Название"><br>
    <button>Сохранить</button>
</form>
@endsection

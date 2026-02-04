@extends('layouts.app')

@section('content')
<h3>Редактирование категории</h3>

<form method="POST" action="/categories/{{ $category->id }}">
    @csrf
    @method('PUT')
    <input name="name" value="{{ $category->name }}" placeholder="Название"><br>
    <button>Сохранить</button>
</form>
@endsection

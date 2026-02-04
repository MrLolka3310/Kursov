@extends('layouts.app')

@section('title', 'Главная')

@section('content')
<h3>Добро пожаловать, {{ auth()->user()->name }}</h3>

<p>Роль: {{ auth()->user()->role->name }}</p>
@endsection

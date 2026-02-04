@extends('layouts.app')

@section('content')
<h3>Новый товар</h3>

<form method="POST" action="/products">
    @csrf
    <input name="name" placeholder="Название"><br>
    <input name="sku" placeholder="Артикул"><br>
    <select name="category_id">
        <option value="">Выберите категорию</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select><br>
    <input name="price" placeholder="Цена"><br>
    <input name="unit" placeholder="Единица измерения"><br>
    <button>Сохранить</button>
</form>
@endsection

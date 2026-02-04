@extends('layouts.app')

@section('content')
<h3>Редактирование товара</h3>

<form method="POST" action="/products/{{ $product->id }}">
    @csrf
    @method('PUT')
    <input name="name" value="{{ $product->name }}" placeholder="Название"><br>
    <input name="sku" value="{{ $product->sku }}" placeholder="Артикул"><br>
    <select name="category_id">
        <option value="">Выберите категорию</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
        @endforeach
    </select><br>
    <input name="price" value="{{ $product->price }}" placeholder="Цена"><br>
    <input name="unit" value="{{ $product->unit }}" placeholder="Единица измерения"><br>
    <button>Сохранить</button>
</form>
@endsection

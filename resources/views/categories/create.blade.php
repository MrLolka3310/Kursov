@extends('layouts.app')

@section('title', 'Новая категория')

@section('page-title')
    <i class="fas fa-plus"></i>
    Новая категория
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div>
                <i class="fas fa-tag"></i>
                Создание категории
            </div>
            <a href="{{ route('categories.index') }}" class="btn btn-outline btn-sm">
                <i class="fas fa-arrow-left"></i>
                Назад
            </a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('categories.store') }}">
                @csrf
                
                <div class="form-group">
                    <label>Название категории *</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')
                        <small style="color: var(--danger-color);">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label>Родительская категория</label>
                    <select name="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
                        <option value="">Нет (корневая категория)</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('parent_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id')
                        <small style="color: var(--danger-color);">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label>Описание</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description') }}</textarea>
                    @error('description')
                        <small style="color: var(--danger-color);">{{ $message }}</small>
                    @enderror
                </div>
                
                <hr>
                
                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i>
                        Сохранить категорию
                    </button>
                    <a href="{{ route('categories.index') }}" class="btn btn-outline">
                        <i class="fas fa-times"></i>
                        Отмена
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
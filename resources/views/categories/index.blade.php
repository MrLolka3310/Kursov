@extends('layouts.app')

@section('title', 'Категории')

@section('page-title')
    <i class="fas fa-tags"></i>
    Категории товаров
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div>
                <i class="fas fa-list"></i>
                Список категорий
            </div>
            <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i>
                Новая категория
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Название</th>
                            <th>Родительская категория</th>
                            <th>Количество товаров</th>
                            <th>Дата создания</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td><strong>{{ $category->name }}</strong></td>
                                <td>{{ $category->parent->name ?? '-' }}</td>
                                <td>{{ $category->products_count ?? $category->products()->count() }}</td>
                                <td>{{ $category->created_at->format('d.m.Y') }}</td>
                                <td>
                                    <div class="table-actions">
                                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-outline" title="Редактировать">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger delete-btn" title="Удалить">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center;">Категории не найдены</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="pagination">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
@endsection
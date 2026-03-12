@extends('layouts.app')

@section('title', 'Новый пользователь')

@section('page-title')
    <i class="fas fa-plus"></i>
    Новый пользователь
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div>
                <i class="fas fa-user-plus"></i>
                Создание пользователя
            </div>
            <a href="{{ route('users.index') }}" class="btn btn-outline btn-sm">
                <i class="fas fa-arrow-left"></i>
                Назад
            </a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('users.store') }}">
                @csrf
                
                <div class="form-group">
                    <label>Имя пользователя *</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')
                        <small style="color: var(--danger-color);">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email')
                        <small style="color: var(--danger-color);">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Пароль *</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                            <small style="color: var(--danger-color);">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label>Подтверждение пароля *</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Роль *</label>
                    <select name="role" class="form-control @error('role') is-invalid @enderror" required>
                        <option value="">Выберите роль</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Администратор</option>
                        <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>Менеджер</option>
                        <option value="storekeeper" {{ old('role') == 'storekeeper' ? 'selected' : '' }}>Кладовщик</option>
                        <option value="analyst" {{ old('role') == 'analyst' ? 'selected' : '' }}>Аналитик</option>
                        <option value="accountant" {{ old('role') == 'accountant' ? 'selected' : '' }}>Бухгалтер</option>
                    </select>
                    @error('role')
                        <small style="color: var(--danger-color);">{{ $message }}</small>
                    @enderror
                </div>
                
                <hr>
                
                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i>
                        Создать пользователя
                    </button>
                    <a href="{{ route('users.index') }}" class="btn btn-outline">
                        <i class="fas fa-times"></i>
                        Отмена
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
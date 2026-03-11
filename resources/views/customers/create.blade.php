@extends('layouts.app')

@section('title', 'Новый клиент')

@section('page-title')
    <i class="fas fa-plus"></i>
    Новый клиент
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div>
                <i class="fas fa-user"></i>
                Создание клиента
            </div>
            <a href="{{ route('customers.index') }}" class="btn btn-outline btn-sm">
                <i class="fas fa-arrow-left"></i>
                Назад
            </a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('customers.store') }}">
                @csrf
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Название / ФИО *</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')
                            <small style="color: var(--danger-color);">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label>Контактное лицо</label>
                        <input type="text" name="contact_person" class="form-control @error('contact_person') is-invalid @enderror" value="{{ old('contact_person') }}">
                        @error('contact_person')
                            <small style="color: var(--danger-color);">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Телефон *</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required>
                        @error('phone')
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
                </div>
                
                <div class="form-group">
                    <label>Адрес</label>
                    <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="2">{{ old('address') }}</textarea>
                    @error('address')
                        <small style="color: var(--danger-color);">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>ИНН</label>
                        <input type="text" name="inn" class="form-control @error('inn') is-invalid @enderror" value="{{ old('inn') }}" maxlength="12">
                        @error('inn')
                            <small style="color: var(--danger-color);">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label>Тип клиента *</label>
                        <select name="customer_type" class="form-control @error('customer_type') is-invalid @enderror" required>
                            <option value="individual" {{ old('customer_type') == 'individual' ? 'selected' : '' }}>Физическое лицо</option>
                            <option value="legal" {{ old('customer_type') == 'legal' ? 'selected' : '' }}>Юридическое лицо</option>
                        </select>
                        @error('customer_type')
                            <small style="color: var(--danger-color);">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label>Скидка (%)</label>
                        <input type="number" name="discount" class="form-control @error('discount') is-invalid @enderror" value="{{ old('discount', 0) }}" step="0.01" min="0" max="100">
                        @error('discount')
                            <small style="color: var(--danger-color);">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                
                <hr>
                
                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i>
                        Сохранить клиента
                    </button>
                    <a href="{{ route('customers.index') }}" class="btn btn-outline">
                        <i class="fas fa-times"></i>
                        Отмена
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
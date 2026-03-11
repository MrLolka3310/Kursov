@extends('layouts.app')

@section('title', 'Новый поставщик')

@section('page-title')
    <i class="fas fa-plus"></i>
    Новый поставщик
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div>
                <i class="fas fa-truck"></i>
                Создание поставщика
            </div>
            <a href="{{ route('suppliers.index') }}" class="btn btn-outline btn-sm">
                <i class="fas fa-arrow-left"></i>
                Назад
            </a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('suppliers.store') }}">
                @csrf
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Название организации *</label>
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
                        <label>КПП</label>
                        <input type="text" name="kpp" class="form-control @error('kpp') is-invalid @enderror" value="{{ old('kpp') }}" maxlength="9">
                        @error('kpp')
                            <small style="color: var(--danger-color);">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label>ОГРН</label>
                        <input type="text" name="ogrn" class="form-control @error('ogrn') is-invalid @enderror" value="{{ old('ogrn') }}" maxlength="15">
                        @error('ogrn')
                            <small style="color: var(--danger-color);">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Банковские реквизиты</label>
                    <textarea name="bank_details" class="form-control @error('bank_details') is-invalid @enderror" rows="3">{{ old('bank_details') }}</textarea>
                    @error('bank_details')
                        <small style="color: var(--danger-color);">{{ $message }}</small>
                    @enderror
                </div>
                
                <hr>
                
                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i>
                        Сохранить поставщика
                    </button>
                    <a href="{{ route('suppliers.index') }}" class="btn btn-outline">
                        <i class="fas fa-times"></i>
                        Отмена
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
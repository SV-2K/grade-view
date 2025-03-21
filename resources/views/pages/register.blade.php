@extends('layouts.main')

@section('main')
    <form>
        <div class="mb-3">
            <label for="name" class="form-label">Имя</label>
            <input type="text" class="form-control" id="name">
        </div>
        @error('name')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" id="email">
        </div>
        @error('email')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
        <div class="mb-3">
            <label for="password" class="form-label">Пароль</label>
            <input type="password" class="form-control" id="password">
        </div>
        @error('password')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Пароль еще раз</label>
            <input type="password" class="form-control" id="password_confirmation">
        </div>
        <a href="{{ route('login.form') }}" class="d-block">У меня уже есть аккаунт</a>
        <button type="submit" class="btn btn-primary mt-4">Создать аккаунт</button>
    </form>
@endsection

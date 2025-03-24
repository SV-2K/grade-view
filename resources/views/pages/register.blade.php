@extends('layouts.small-window')

@section('main')
    <h2>Регистрация</h2>
    <form action="{{ route('register.action') }}" method="post">
        @csrf
        <div class="mb-3 mt-4">
            <label for="name" class="form-label">Имя</label>
            <input type="text" class="form-control input-bar @error('name')is-invalid @enderror" value="{{ old('name') }}" name="name" id="name">
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control input-bar @error('email')is-invalid @enderror" value="{{ old('email') }}" name="email" id="email">
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Пароль</label>
            <input type="password" class="form-control input-bar @error('password')is-invalid @enderror" name="password" id="password">
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Пароль еще раз</label>
            <input type="password" class="form-control input-bar" name="password_confirmation" id="password_confirmation">
        </div>
        <a href="{{ route('login.form') }}" class="d-block link">У меня уже есть аккаунт</a>
        <button type="submit" class="btn section mt-4">Создать аккаунт</button>
    </form>
@endsection

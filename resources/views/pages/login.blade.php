@extends('layouts.main')

@section('main')
    @if(session()->has('error'))
        <div class="alert alert-danger" role="alert">
            {{ session()->get('error') }}
        </div>
    @endif
    <form method="post">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control @error('email')is-invalid @enderror" value="{{ old('email') }}" name="email" id="email">
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Пароль</label>
            <input type="password" class="form-control @error('password')is-invalid @enderror" name="password" id="password">
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <a href="{{ route('register.form') }}" class="d-block">У меня еще нет аккаунта</a>
        <button type="submit" class="btn btn-primary mt-4">Создать аккаунт</button>
    </form>
@endsection

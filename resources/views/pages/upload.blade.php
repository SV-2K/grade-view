@extends('layouts.medium-window')

@section('main')
    <a href="{{ route('profile') }}" class="section ps-1">&#8592; Назад в профиль</a>
    <h1 class="d-block mt-3">Загрузка мониторинга</h1>
    <form action="{{ route('monitoring.upload') }}" method="post" onsubmit="disableButton(this)" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Название мониторинга</label>
            <input class="form-control @error('name') is-invalid @enderror" type="text" value="{{ old('name') }}" name="name" id="name">
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="start-date" class="form-label">Дата начала мониторинга</label>
            <input class="form-control @error('start-date') is-invalid @enderror" type="date" value="{{ old('start-date') }}" name="start-date" id="start-date">
            @error('uploadFiles')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="end-date" class="form-label">Дата окончания мониторинга</label>
            <input class="form-control @error('end-date') is-invalid @enderror" type="date" value="{{ old('end-date') }}" name="end-date" id="end-date">
            @error('end-date')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="uploaded-files" class="form-label">Выберите файл(ы) мониторинга</label>
            <input class="form-control @error('uploaded-files') is-invalid @enderror" type="file" name="uploaded-files[]" id="uploaded-files" multiple>
            @error('uploaded-files')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Загрузить</button>
    </form>
    <script>
        function disableButton(form) {
            const button = form.querySelector('button[type="submit"]');
            button.disabled = true;
            button.innerText = 'Загрузка...';
        }
    </script>
@endsection

@extends('layouts.medium-window')

@section('main')
    <h1>Загрузка мониторинга</h1>
    <form action="{{ route('monitoring.upload') }}" method="post" enctype="multipart/form-data">
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
            <label for="startDate" class="form-label">Дата начала мониторинга</label>
            <input class="form-control @error('startDate') is-invalid @enderror" type="date" value="{{ old('startDate') }}" name="startDate" id="startDate">
            @error('startDate')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="endDate" class="form-label">Дата окончания мониторинга</label>
            <input class="form-control @error('endDate') is-invalid @enderror" type="date" value="{{ old('endDate') }}" name="endDate" id="endDate">
            @error('endDate')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="uploadFiles" class="form-label">Выберите файл(ы) мониторинга</label>
            <input class="form-control @error('uploadFiles') is-invalid @enderror" type="file" name="uploadFiles" id="uploadFiles">
            @error('uploadFiles')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Загрузить</button>
    </form>
@endsection

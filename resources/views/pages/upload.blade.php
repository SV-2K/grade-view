@extends('layouts.main')

@section('main')
    <form action="{{ route('monitoring.upload') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="formFile" class="form-label">Загрузите файл мониторинга</label>
            <input class="form-control @error('monitoring') is-invalid @enderror" type="file" name="monitoring" id="monitoring">
            @error('monitoring')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Загрузить</button>
    </form>
@endsection

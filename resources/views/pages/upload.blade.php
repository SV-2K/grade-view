@extends('layouts.main')

@section('main')
    <form action="#" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="formFile" class="form-label">Загрузите файл мониторинга</label>
            <input class="form-control" type="file" name="monitoring" id="monitoring">
        </div>
        <button type="submit" class="btn btn-primary">Загрузить</button>
    </form>
@endsection

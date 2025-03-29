@extends('layouts.medium-window')
@section('main')
    <h1>Профиль</h1>
    <div class="mb-4">
        {{ auth()->user()->name }} ({{ auth()->user()->email }})
        <a href="{{ route('logout') }}" class="section">Выйти из аккаунта</a>
    </div>
    <a href="{{ route('monitoring.upload') }}" class="section">Загрузить мониторинг</a>
    <div class="section-inward d-flex flex-column gap-4 mt-3">
        @foreach($monitorings as $key => $monitoring)
            <div class="section d-flex justify-content-between">
                <a href="{{ route('college', ['monitoring' => $monitoring['id']]) }}" class="label">
                    {{ $monitoring['name'] }} (с {{ $monitoring['start_date'] }} по {{ $monitoring['end_date'] }})
                </a>
                <form action="{{ route('monitoring.delete', ['id' => $monitoring['id']]) }}" id="deleteForm{{ $key }}" method="post">
                    @csrf
                    <button type="button" class="btn-close" id="deleteButton{{ $key }}"></button>
                </form>
            </div>
        @endforeach
    </div>
    @foreach($monitorings as $key => $monitoring)
        <script>
            document.getElementById('deleteButton{{ $key }}').addEventListener('click', function () {
                if (confirm('Вы действительно хотите удалить мониторинг?')) {
                    document.getElementById('deleteForm{{ $key }}').submit();
                }
            })
        </script>
    @endforeach
@endsection

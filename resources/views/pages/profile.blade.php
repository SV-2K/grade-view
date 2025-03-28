@extends('layouts.medium-window')
@section('main')
    <h1>Профиль</h1>
    <div class="mb-4">
        {{ auth()->user()->name }} ({{ auth()->user()->email }})
        <a href="{{ route('logout') }}" class="section">Выйти из аккаунта</a>
    </div>
    <a href="{{ route('monitoring.upload') }}" class="section">Загрузить мониторинг</a>
    <div class="section-inward d-flex flex-column gap-4 mt-3">
        @foreach($monitorings as $monitoring)
            <a href="{{ route('college', ['monitoring' => $monitoring['id']]) }}" class="section">
                {{ $monitoring['name'] }} (с {{ $monitoring['start_date'] }} по {{ $monitoring['end_date'] }})
            </a>
        @endforeach
    </div>
@endsection

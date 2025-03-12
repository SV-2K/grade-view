@extends('layouts.main')

@section('main')
    <div class="top-section">
        <h3 class="m-0 section">
            @php
                echo $group ?? 'Выберите группу...';
            @endphp
        </h3>
        <form class="d-flex gap-4" role="search" method="post">
            <input class="search-bar input" type="search" placeholder="Поиск (не работает)" aria-label="Search">
            <button class="search-button" type="submit">&#128269;</button>
        </form>
    </div>
    <div class="container text-center mt-4">
        <div class="row">
            <div class="col-8 p-0">
                <div id="quality-performance" class="section me-4 h-100 p-0">
                    @include('charts.quality-performance')
                </div>
            </div>
            <div class="col-4 p-0">
                <div class="info-section">
                    <div class="section">
                        Средний балл:
                    </div>
                    <div class="section">
                        Абсолютная успеваемость:
                    </div>
                    <div class="section">
                        Качественная успеваемость:
                    </div>
                    <div class="section">
                        Количество студентов:
                    </div>
                </div>
                <div id="grades-ratio" class="section mt-4 p-0" style="height: 450px">
                    @include('charts.grades-ratio')
                </div>
            </div>
        </div>
        <div class="row gap-4 mt-4">
            <div id="absence-ratio" class="section col-1 p-0">
                @include('charts.absence-ratio')
            </div>
            <div id="grade-distribution" class="section col p-0" style="height: 300px">
                @include('charts.grade-distribution')
            </div>
        </div>
    </div>
@endsection

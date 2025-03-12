@extends('layouts.main')

@section('main')
    <div class="top-section">
        <h3 class="m-0 section">
            Статистика колледжа
        </h3>
    </div>
    <div class="container text-center mt-4">
        <div class="row gap-4">
            <div id="quality-performance" class="section col-7">
                @include('charts.quality-performance')
            </div>
            <div class="row col-5 gap-0">
                <div class="col-3 p-0">
                    <div id="absence-ratio" class="section me-4 h-100 p-0">
                        @include('charts.absence-ratio')
                    </div>
                </div>
                <div class="col-9 gap-4 p-0">
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
                            Количество групп:
                        </div>
                        <div class="section">
                            Количество студентов:
                        </div>
                    </div>
                    <div id="grades-ratio" class="section mt-4 p-0" style="height: 400px">
                        @include('charts.grades-ratio')
                    </div>
                </div>
                <div class="row m-0 mt-4 p-0">
                    <div id="average-grades" class="section" style="height: 300px;">
                        @include('charts.average-grades')
                        dsd
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

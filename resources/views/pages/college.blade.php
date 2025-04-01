@extends('layouts.main')

@section('main')
    <div class="row gap-4 container-fluid">
        <div class="section col-7 d-flex flex-column">
            <div>Качественная успеваемость по предметам в %</div>
            <div id="quality-performance" class="flex-grow-1">
                @include('charts.quality-performance')
            </div>
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
                        Средний балл: {{ round($averageGrade, 2) ?? 'Error' }}
                    </div>
                    <div class="section">
                        Абсолютная успеваемость: {{ round($absolutePerformance, 2) . '%' ?? 'Error' }}
                    </div>
                    <div class="section">
                        Качественная успеваемость: {{ round($qualityPerformance, 2) . '%' ?? 'Error' }}
                    </div>
                    <div class="section">
                        Количество групп: {{ $groupsAmount ?? 'Error' }}
                    </div>
                    <div class="section">
                        Количество студентов: {{ $studentsAmount ?? 'Error' }}
                    </div>
                    <div class="section">
                        Количество оценок: {{ $gradesAmount ?? 'Error' }}
                    </div>
                </div>
                <div class="section mt-4 p-2 text-center d-flex flex-column" style="height: 400px">
                    <div>Соотношение оценок</div>
                    <div id="grades-ratio" class="flex-grow-1">
                        @include('charts.grades-ratio')
                    </div>
                </div>
            </div>
            <div class="row m-0 mt-4 p-0">
                <div class="section d-flex flex-column з-2" style="height: 1000px;">
                    <div>Средний балл по группам</div>
                    <div id="average-grades" class="flex-grow-1">
                        @include('charts.average-grades')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

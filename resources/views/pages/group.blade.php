@extends('layouts.main')

@section('main')
    @if($isEmpty)
        <div class="row text-center section" style="height: 300px">
            <h1 class="m-auto">Выберите группу...</h1>
        </div>
    @else
        <div class="row">
            <div class="col-8 p-0">
                <div id="quality-performance" class="section me-4 h-100 p-0">
                    @include('charts.quality-performance')
                </div>
            </div>
            <div class="col-4 p-0">
                <div class="info-section">
                    <div class="section">
                        Средний балл: {{ round($averageGrade, 2) }}
                    </div>
                    <div class="section">
                        Абсолютная успеваемость: {{ round($absolutePerformance, 2) }}%
                    </div>
                    <div class="section">
                        Качественная успеваемость: {{ round($qualityPerformance, 2) }}%
                    </div>
                    <div class="section">
                        Количество студентов: {{ $studentsAmount }}
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
    @endif
@endsection

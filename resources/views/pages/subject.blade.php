@extends('layouts.main')

@section('main')
    @if($isEmpty)
        <div class="row text-center section m-0 me-4" style="height: 300px">
            <h1 class="m-auto">Выберите предмет...</h1>
        </div>
    @else
        <div class="row container-fluid">
            <div class="col-8 p-0 pe-4">
                <div id="average-grades" class="section h-50 p-0">
                    @include('charts.average-grades')
                </div>
                <div class="h-50 p-0 pt-4">
                    <div id="grade-distribution" class="section h-100 p-0">
                        @include('charts.grade-distribution')
                    </div>
                </div>
            </div>
            <div class="col-4 gap-4 p-0">
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
                        Количество групп: {{ $groupsAmount }}
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
    @endif
@endsection

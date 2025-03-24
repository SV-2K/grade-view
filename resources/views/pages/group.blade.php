@extends('layouts.main')

@section('main')
    @if($isEmpty)
        <div class="row text-center section m-0 me-4" style="height: 300px">
            <h1 class="m-auto">Выберите группу...</h1>
        </div>
    @else
        <div class="p-0">
            <div class="row container-fluid g-4 me-4">
                <div class="col-5 p-0 pe-4">
                    <div id="grades-ratio" class="section h-100">
                        @include('charts.grades-ratio')
                    </div>
                </div>
                <div id="absence-ratio" class="section col-1 p-0">
                    @include('charts.absence-ratio')
                </div>
                <div class="ps-4 col-6 p-0">
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
                </div>
            </div>
            <div class="p-0 flex-grow-1 me-4 mt-4">
                <div id="quality-performance" class="section p-0">
                    @include('charts.quality-performance')
                </div>
            </div>
        </div>
        <div class="row gap-4 mt-4 container-fluid">
            <div id="grade-distribution" class="section col p-0" style="height: 230px">
                @include('charts.grade-distribution')
            </div>
        </div>
    @endif
@endsection

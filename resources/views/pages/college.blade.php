@extends('layouts.main')

@section('main')
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
                </div>
                <div id="grades-ratio" class="section mt-4 p-0" style="height: 400px">
                    @include('charts.grades-ratio')
                </div>
            </div>
            <div class="row m-0 mt-4 p-0">
                <div id="average-grades" class="section" style="height: 1000px;">
                    @include('charts.average-grades')
                    dsd
                </div>
            </div>
        </div>
    </div>
@endsection

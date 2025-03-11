@extends('layouts.main')

@section('main')
    <div class="top-section">
        <h3 class="m-0 section">
            Статистика колледжа
        </h3>
    </div>
    <div class="container text-center mt-4">
        <div class="row gap-4">
            <div class="section col-7">
                Column 1
            </div>
            <div class="row col-5 gap-0">
                <div class="col-3 p-0">
                    <div class="section me-4 h-100">
                        Column 2
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
                    <div id="grade-ratio" class="section mt-4 p-0" style="height: 400px">
                        @include('charts.grade-ratio')
                    </div>
                </div>
                <div class="row m-0 mt-4 p-0">
                    <div class="section ">
                        Column 3
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

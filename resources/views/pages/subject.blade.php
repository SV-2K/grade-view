@extends('layouts.main')

@section('main')
    <div class="top-section">
        <h3 class="m-0 section">
            @php
                echo $subject ?? 'Выберите предмет...';
            @endphp
        </h3>
        <form class="d-flex gap-4" role="search" method="post">
            <input class="search-bar input" type="search" placeholder="Поиск (не работает)" aria-label="Search">
            <button class="search-button" type="submit">&#128269;</button>
        </form>
    </div>
    <div class="container text-center mt-4">
        <div class="row gap-4">
            <div id="chart" class="section col-8">

            </div>
            <div class="col gap-4 p-0">
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
                <div class="section mt-4" >
                    Column
                </div>
            </div>
        </div>
        <div class="row mt-4 z-0">
            <div class="section ">
                Column
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            console.log("C3.js загружен, создаем график...");

            var chart = c3.generate({
                bindto: '#chart',
                data: {
                    columns: [
                        ['data1', 30, 200, 100, 400, 150, 250],
                        ['data2', 50, 20, 10, 40, 15, 25]
                    ]
                }
            });

            console.log("График должен был отобразиться.");
        });

    </script>
@endsection

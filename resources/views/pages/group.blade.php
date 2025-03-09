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
        <div class="row gap-4">
            <div class="section col">
                Column
            </div>
            <div class="col-4 gap-4 p-0">
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
                <div class="section col mt-4" >
                    Column
                </div>
            </div>
        </div>
        <div class="row gap-4 mt-4">
            <div class="section col">
                Column
            </div>
            <div class="section col-1">
                Column
            </div>
        </div>
    </div>
@endsection

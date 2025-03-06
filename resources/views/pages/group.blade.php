@extends('layouts.main')

@section('main')
    <div class="top-section p-3" >
        <h3 class="m-0">
            @if(isset($group))
                Группа {{ $group }}
            @else
                Выберите группу...
            @endif
        </h3>
    </div>
    <div class="container text-center mt-2">
        <div class="row gap-2">
            <div class="col-4 gap-2 p-0">
                <div class="info-section">
                    <div class="info-section-row">
                        <div class="section">
                            Информация по группе:
                        </div>
                        <div class="info-item">
                            asdfsa
                        </div>
                        <div class="filler"></div>
                    </div>
                    <div class="info-section-row">
                        <div class="section">
                            Средний балл:
                        </div>
                        <div class="info-item">
                            asdfsa
                        </div>
                        <div class="filler"></div>
                    </div>
                    <div class="info-section-row">
                        <div class="section">
                            Абсолютная успеваемость:
                        </div>
                        <div class="info-item">
                            asdfsa
                        </div>
                        <div class="filler"></div>
                    </div>
                    <div class="info-section-row">
                        <div class="section">
                            Качественная успеваемость:
                        </div>
                        <div class="info-item">
                            asdfsa
                        </div>
                        <div class="filler"></div>
                    </div>
                    <div class="info-section-row">
                        <div class="section">
                            Количество студентов:
                        </div>
                        <div class="info-item">
                            asdfsa
                        </div>
                        <div class="filler"></div>
                    </div>
                </div>
                <div class="section col mt-2" >
                    Column
                </div>
            </div>
            <div class="section col">
                Column
            </div>
        </div>
        <div class="row gap-2 mt-2">
            <div class="section col">
                Column
            </div>
            <div class="section col-1">
                Column
            </div>
        </div>
    </div>
    <div class="bottom-section mt-2"></div>
@endsection

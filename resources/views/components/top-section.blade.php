    <div class="m-0 me-4 mb-4 section">
        <div class="d-flex">
            <div class="fs-4 mb-0 me-2">
                {{ $monitoring->name ?? 'Ошибка загрузки названия мониторинга' }}
            </div>
            {{ date('d.m.Y', strtotime($monitoring->start_date)) }}
            -
            {{ date('d.m.Y', strtotime($monitoring->end_date)) }}
        </div>

        <div class="fs-2">
            @php
                if (\Illuminate\Support\Facades\Route::is('group')) {
                    echo $group ?? 'Группа не выбрана...';
                } else if (\Illuminate\Support\Facades\Route::is('subject')) {
                    echo $subject ?? 'Предмет не выбран...';
                }
            @endphp
        </div>
    </div>
{{--    <form class="d-flex gap-4" role="search" method="post">--}}
{{--        <input class="search-bar input" type="search" placeholder="Поиск (не работает)" aria-label="Search">--}}
{{--        <button class="search-button" type="submit">&#128269;</button>--}}
{{--    </form>--}}

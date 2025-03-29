    <div class="m-0 me-4 mb-4 section">
        <div class="fs-4 mb-0">
            {{ $monitoring->name ?? 'Ошибка загрузки названия мониторинга' }}
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

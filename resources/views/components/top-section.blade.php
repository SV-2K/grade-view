<div class="top-section mb-4 p-0 col-6 mx-auto">
    <h3 class="m-0 section">
        @php
            echo $group ?? 'Группа не выбрана...';
        @endphp
    </h3>
    <form class="d-flex gap-4" role="search" method="post">
        <input class="search-bar input" type="search" placeholder="Поиск (не работает)" aria-label="Search">
        <button class="search-button" type="submit">&#128269;</button>
    </form>
</div>

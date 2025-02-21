<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('group') }}">Grade view</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="nav-link" href="{{ route('feedback') }}">Фидбек</a>
        <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route('group') }}">Группа</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('college') }}">Колледж</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('subject') }}">Предмет</a>
                </li>
            </ul>
        </div>
        <a class="nav-link" href="{{ route('upload.page') }}">Загрузить</a>
    </div>
</nav>

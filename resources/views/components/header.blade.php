@php
    $groups = \App\Models\Group::all();
    $subjects = \App\Models\Subject::all();
@endphp

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
                    @if(Request::is('group'))
                        <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
                            <ul class="navbar-nav">
                                <li class="nav-item dropdown">
                                    <a class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        Группа
                                    </a>
                                    <ul class="dropdown-menu">
                                        @foreach($groups as $group)
                                            <li><a class="dropdown-item" href="{{ route('group', ['name' => $group->name]) }}">{{ $group->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a class="nav-link" aria-current="page" href="{{ route('group') }}">Группа</a>
                    @endif
                </li>
                <li class="nav-item">
                    @if(Request::is('college'))
                        <button class="btn btn-primary">Колледж</button>
                    @else
                        <a class="nav-link" href="{{ route('college') }}">Колледж</a>
                    @endif
                </li>
                <li class="nav-item">
                    @if(Request::is('subject'))
                        <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
                            <ul class="navbar-nav">
                                <li class="nav-item dropdown">
                                    <a class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        Предмет
                                    </a>
                                    <ul class="dropdown-menu">
                                        @foreach($subjects as $subject)
                                            <li><a class="dropdown-item" href="{{ route('subject', ['name' => $subject->name]) }}">{{ $subject->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a class="nav-link" aria-current="page" href="{{ route('subject') }}">Предмет</a>
                    @endif
                </li>
            </ul>
        </div>
        <a class="nav-link m-lg-1" href="{{ route('register.form') }}">Регистрация</a>
        <a class="nav-link m-lg-1" href="{{ route('login.form') }}">Логин</a>
        <a class="nav-link m-lg-1" href="{{ route('upload.page') }}">Загрузить</a>
    </div>
</nav>

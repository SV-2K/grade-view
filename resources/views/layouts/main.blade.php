<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/c3.min.css') }}">
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/d3.min.js') }}"></script>
    <script src="{{ asset('js/c3.min.js') }}"></script>
    <title>Document</title>
</head>
<body>
    <div class="">
        <header>
            @include('components.header')
        </header>
        <main>
            @include('components.top-section')
            <div class="row d-flex">
                <div class="col-3 me-3">
                    @include('components.side-menu')
                </div>
                <div class="col-6 text-center p-0">
                    @yield('main')
                </div>
                <div class="col-3">

                </div>
            </div>
        </main>
    </div>
</body>
</html>

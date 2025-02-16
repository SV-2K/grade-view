<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <title>Document</title>
</head>
<body>
    <div class="container">
        <header>
            @include('components.header')
        </header>
        <main>
            <div class="container mt-5 p-3" style="background-color: #e3e3e3">
                @yield('main')
            </div>
        </main>
    </div>
</body>
</html>

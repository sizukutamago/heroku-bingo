<!doctype html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <title>heroku bingo!</title>
    </head>
    <body>
        <header class="header">
            <p class="header-title"><a class="top-link" href="{{ route('index') }}">binbinbingo!</a></p>
        </header>

        <div id="app" class="center">
            @yield('content')
        </div>

        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>

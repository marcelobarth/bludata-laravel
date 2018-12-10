<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Bludata</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{!! asset('css/style.css') !!}" rel="stylesheet">

    <link  href="{!! asset('https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" rel="stylesheet" crossorigin="anonymous') !!}">

</head>
<body>
    <div class="flex-center position-ref full-height">
        @if (Route::has('login'))
        <div class="top-right links">
            @auth
            <a href="{{ url('/painel') }}">Painel</a>
            @else
            <a href="{{ route('login') }}">Logar</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}">Resgistrar</a>
            @endif
            @endauth
        </div>
        @endif

        <div class="content">
            <div class="title m-b-md">
                Bludata
            </div>

            <div class="links">
                 <a href="https://www.bludata.com.br/">Bludata</a>
                 <a href="https://github.com/marcelobarth">GitHub</a>
            </div>
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="{{ URL::asset('css/style.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/3.2.30/vue.global.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    
</head>
<body>
    <nav>
        <ul>
            <li class="selected-menu">
                <a  href="{{url('/')}}/">Kezdőlap</a>
            </li>
            <li>
                <a href="/tortenet">Történet</a>
            </li>
            <li>
                <a href="/osszeallitasok">Összeállítások</a>
            </li>
            <li>
                <a href="/setlist">Set-ek</a>
            </li>
            <li>
                <a href="/palyaismerteto">Pályaismertető</a>
            </li>
            @guest
                @if (Route::has('login'))
                    <li class="nav-item">
                        <a style="padding: 1px 1rem;" class="nav-link" href="{{ route('login') }}">Bejelentkezés</a>
                    </li>
                @endif

                @if (Route::has('register'))
                    <li class="nav-item">
                        <a style="padding: 1px 1rem" class="nav-link" href="{{ route('register') }}">Regisztráció</a>
                    </li>
                @endif
            @else
                <li class="nav-item dropdown">
                    <a style="padding: 1px 1rem" id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-on:click="openDropdown(isOpen)" v-pre>
                        {{ Auth::user()->name }}
                    </a>

                    <div id="dropdownMenu" class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown" v-if="isOpen">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                            Kijelentkezés
                        </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                    </div>
                </li>
            @endguest
        </ul>
    </nav>
    <header>
        <img class="previous-z-index" src="/images/header.png">
        <img class="next-z-index" src="/images/header2.png">
        <img src="/images/header3.png">

        <div class="header-btn-holder">
            <div class="dot selected-dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
    </header>

    @yield('content')

    <script src="{{URL::asset('js/header.js')}}"></script>
    <script>
            $("body").on("click", "#navbarDropdown", function() {
                $("#dropdownMenu").toggle();
            });
    </script>
</body>
</html>
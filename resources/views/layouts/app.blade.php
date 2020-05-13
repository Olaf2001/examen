<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>NotesVH</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    NotesVH
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <a class="nav-link" href="{{ url('./notes')}}">Notities</a>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                    @can('admin functions')
                                        @if (Route::has('register'))
                                            <a class="dropdown-item" href="{{ route('register') }}">{{ __('Register') }}</a>
                                        @endif
                                        <a class="dropdown-item" href="{{ url('./users') }}">Alle gebruikers</a>
                                    @endcan
                                    <a class="dropdown-item" style="cursor: pointer;" data-toggle="modal" data-target="#myData">Mijn gegevens</a>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        @auth
            <div>
                <!-- Edit Modal -->
                <div class="modal fade" id="myData">
                    <div class="modal-dialog">
                    <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Gebruiker aanpassen</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <form action="{{ route('users.update', Auth::user()) }}" method="POST">
                                @csrf
                                @method('PUT')
                                                                                
                                <!-- Modal Body -->
                                <div class="modal-body">
                                    <div class="container">
                                        <label>Naam van de gebruiker</label>
                                        <input name="name" type="text" class="form-control" placeholder="Vul hier de naam in" value="{{ Auth::user()->name }}">
                                        <label>Email van de gebruiker</label>
                                        <input name="email" type="email" class="form-control" placeholder="Vul hier de email in" value="{{ Auth::user()->email }}">
                                        <a class="btn btn-link" href="change-password" data-toggle="collapse">Wachtwoord aanpassen</a>
                                        <div id="change-password" class="collapse">
                                            <label>Nieuw wachtwoord van gebruiker</label>
                                            <input name="password" type="password" class="form-control" placeholder="Vul het nieuwe wachtwoord in">
                                            <label>Herhaal nieuw wachtwoord van gebruiker</label>
                                            <input name="password2" type="password" class="form-control" placeholder="Vul het nieuwe wachtwoord in">
                                            <span class="text-danger">Wachtwoord aanpassen is niet verplicht, dus wil je ze niet veranderen, laat de velden leeg</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Footer -->
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-warning">Gebruiker Aanpassen</button>
                                </div>
                            </form>
                       </div>
                   </div>
                </div>
            </div>
        @endauth

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>

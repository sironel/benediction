<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
     @yield('css')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light  shadow-sm" style="background-color: #ccffcc;">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto pull-right">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                     @switch(Auth::user()->user_level)
                                      @case(config('benediction.Administrateur'))
                                               (Administrateur)
                                            @break

                                        @case(config('benediction.Magasinier'))
                                           (Magasinier)
                                            @break

                                        @case(config('benediction.Comptable'))
                                           (Comptable)
                                            @break

                                        @case(config('benediction.Operateur'))
                                           (Operateur)
                                            @break

                                        @case(config('benediction.Client'))
                                           (Client)
                                            @break

                                        @case(config('benediction.Utilisateur'))
                                           (Utilisateur)
                                            @break

                                        @default
                                            <span>Inconnu</span>
                                    @endswitch

                                    <!-- <span class="caret"></span> -->
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
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @if(Session::has('msg'))

            <div class="toast" id="myToast" style="position: absolute; top: 0; right: 0; min-width: 400px;" data-delay="5000" data-animation="true">
                  <div class="toast-header">
                    <strong class="mr-auto"><i class="fa fa-grav"></i> UNIC</strong>
                    <small>  </small>
                    <button type="button" class="ml-2 mb-1 close" >&times;</button>
                 </div>
                 <div class="toast-body">
                    {!!Session::get('msg')!!}  <a href="#">  </a>
                 </div>
            </div>
           @endif

            @if (\Request::is('login') || \Request::is('register')|| \Request::is('home'))
                @yield('content')
            @else
           <div class="row">

                <div class="col-md-2 infoblock">

                    <!-- The sidebar -->
                    <div class="sidebar">
                      <a class="active" href="#home" ><i class="fa fa-home fa-1x px-1"></i>Accueil</a>
                      <a href="/produits"><i class="fa fa-briefcase fa-1x px-1"></i>Article</a>
                      <a href="#commande"><i class="fa fa-tasks fa-1x px-1"></i>Commande</a>
                      <a href="#proformat"><i class="fa fa-table fa-1x px-1"></i>Proformat</a>
                      <a href="#achat"><i class="fa fa-file fa-1x px-1"></i>Achat</a>
                      <a href="#stock"><i class="fa fa-box-open fa-1x px-1"></i>Stock</a>
                      <a href="/prix-produit"><i class="fa fa-coins fa-1x px-1"></i>Prix</a>
                      <a href="#reglement"><i class="fa fa-balance-scale fa-1x px-1"></i>Reglement</a>
                      <a href="#statistiques"><i class="fa fa-chart-line fa-1x px-1"></i>Statistiques</a>
                    </div>

                </div>

                <!-- colonne 2 -->

                <div class="col-md-10 infoblock">

                     @yield('content')
                </div>


                </div>
            @endif

        </main>
    </div>
    <script>
$(document).ready(function(){
    $("#myToast").toast('show');

});
</script>
</body>
</html>

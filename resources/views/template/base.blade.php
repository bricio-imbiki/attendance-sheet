<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>@yield('title', 'Fiche de présence')</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />

        @vite('resources/css/app.css')
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
            <div class="container px-4">
                <a class="navbar-brand w-25" href="#page-top">Fiche de présence</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link @if($active === 'home') active @endif" href="{{ route('home') }}">Les évènements</a></li>
                        <li class="nav-item"><a class="nav-link @if($active === 'about') active @endif" href="{{ route('about') }}">A propos</a></li>
                        <li class="nav-item"><a class="nav-link @if($active === 'login') active @endif" href="{{ route('login') }}">Se connecter</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="min-vh-100  ">
            @yield('content')
        </div>

        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container px-4"><p class="m-0 text-center text-white">Copyright &copy; Imbiki Bricio 2022</p></div>
        </footer>

        @vite('resources/js/app.js')

        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <link href="{{ asset('select2/css/select2.min.css') }}" rel="stylesheet" />
            <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
                <link href="{{ asset('bootstrap/css/bootstrap-grid.min.css') }}" rel="stylesheet" />

        <script src="{{ asset('select2/js/select2.full.min.js') }}"></script>
         <script src="{{ asset('bootstrap/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
       <script src="{{ asset('bootstrap/js/bootstrap.esm.min.js') }}"></script>
        @stack('scripts')
    </body>
</html>

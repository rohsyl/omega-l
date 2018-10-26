<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Omega CMS login">
    <meta name="author" content="Roh Sylvain">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ 'OmegaCMS' }} - {{ __('Login') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <script src="{{ asset('js/jquery-2.0.3.min.js') }}" defer></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
    <script src="{{ asset('js/jquery.growl.js') }}" defer></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.growl.css') }}" rel="stylesheet">
    <link href="{{ asset('css/omega.custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/omega.login.css') }}" rel="stylesheet">


    <!--[if lt IE 9]>
    <script src="{{ asset('js/html5shiv.js') }}"></script>
    <script src="{{ asset('js/respond.min.js') }}"></script>
    <![endif]-->
</head>
<body>
    <div id="app">
        <div class="container-login">
            <div class="card-login">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header">
                            <h2>Login <small>Omega CMS</small></h2>
                        </div>

                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>



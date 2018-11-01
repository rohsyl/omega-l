<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Omega CMS administration">
    <meta name="author" content="Roh Sylvain">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="absurl" content="{{ route('admin.home')  }}">

    <title>{{ 'OmegaCMS' }} - {{ __('administration') }}</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')

    <!-- Scripts -->
    @routes
    <script src="{{ asset('js/bundle.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <!--
    <script src="{{ asset('js/jquery.ui.touch-punch.min.js') }}" defer></script>
    <script src="{{ asset('js/jquery.finger.js') }}" defer></script>
    -->
    <script src="{{ route('language.loadforjs') }}"></script>
    <script src="{{ route('js.loadmain') }}"></script>

    @stack('scripts')

    @include('toast::messages-jquery')


    <!--[if lt IE 9]>
    <script src="{{ asset('js/html5shiv.js') }}"></script>
    <script src="{{ asset('js/respond.min.js') }}"></script>
    <![endif]-->
</head>
<body>

    <div id="wrapper">
        <div id="app">
            @include('menu.admin')
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>



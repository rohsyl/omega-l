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

    <title>{{ config('app.name', 'OmegaCMS') }} - {{ __('administration') }}</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <!--<link href="{{ asset('css/app.css') }}" rel="stylesheet">-->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/metisMenu.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('js/summernote/summernote.css') }}" rel="stylesheet">
    <link href="{{ asset('js/bootstrap3-editable/css/bootstrap-editable.css') }}" rel="stylesheet">
    <link href="{{ asset('js/bootstrap3-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('js/bootstrap-iconpicker/css/bootstrap-iconpicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/omega.custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/omega.admin.css') }}" rel="stylesheet">
        @stack('styles')

    <!-- Scripts -->
    <!--<script src="{{ asset('js/app.js') }}" defer></script>-->
<!--<script src="{{ 's'/*asset('Url::Action('language', 'loadforjs')*/ }}" defer></script>-->
    <script src="{{ asset('js/jquery-2.0.3.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}" defer></script>
    <script src="{{ asset('js/jquery.ui.touch-punch.min.js') }}" defer></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
    <script src="{{ asset('js/metisMenu.min.js') }}" defer></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}" defer></script>
    <script src="{{ asset('js/toastr.min.js') }}" defer></script>
    <script src="{{ asset('js/jquery.finger.js') }}" defer></script>
    <script src="{{ asset('js/plupload.full.min.js') }}" defer></script>
    <script src="{{ asset('js/summernote/summernote.min.js') }}" defer></script>
    <script src="{{ asset('js/word_entity_scrubber.js') }}" defer></script>
    <script src="{{ asset('js/bootstrap3-editable/js/bootstrap-editable.min.js') }}" defer></script>
    <script src="{{ asset('js/bootstrap3-datepicker/js/bootstrap-datepicker.min.js') }}" defer></script>
    <script src="{{ asset('js/bootstrap-iconpicker/js/iconset/iconset-fontawesome-4.3.0.min.js') }}" defer></script>
    <script src="{{ asset('js/bootstrap-iconpicker/js/bootstrap-iconpicker.min.js') }}" defer></script>


    <script src="{{ asset('js/omega.admin.js') }}" defer></script>
    <script src="{{ asset('js/jquery.rsExplorer.js') }}" defer></script>
    <script src="{{ asset('js/jquery.rsMediaChooser.js') }}" defer></script>
    <script src="{{ asset('js/jquery.rsModuleChooser.js') }}" defer></script>

    <script src="{{ asset('js/omega/omega.js') }}" defer></script>
    <script src="{{ asset('js/omega/omegaAjax.js') }}" defer></script>
    <script src="{{ asset('js/omega/omegaHtml.js') }}" defer></script>
    <script src="{{ asset('js/omega/omegaModal.js') }}" defer></script>
    <script src="{{ asset('js/omega/omegaNotice.js') }}" defer></script>
    <script src="{{ asset('js/omega/omegaMvc.js') }}" defer></script>
    <script src="{{ asset('js/omega/omegaLocation.js') }}" defer></script>
    <script src="{{ asset('js/omega/omegaPlugin.js') }}" defer></script>
    <script src="{{ asset('js/omega/omegaPluginMvc.js') }}" defer></script>

    <script src="{{ route('js.loadmain') }}" defer></script>
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



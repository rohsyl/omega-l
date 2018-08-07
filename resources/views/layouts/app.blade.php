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

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <script src="{{ asset('js/omega/omega.js') }}" defer></script>
    <script src="{{ asset('js/omega/omegaAjax.js') }}" defer></script>
    <script src="{{ asset('js/omega/omegaHtml.js') }}" defer></script>
    <script src="{{ asset('js/omega/omegaModal.js') }}" defer></script>
    <script src="{{ asset('js/omega/omegaNotice.js') }}" defer></script>
    <script src="{{ asset('js/omega/omegaMvc.js') }}" defer></script>
    <script src="{{ asset('js/omega/omegaLocation.js') }}" defer></script>
    <script src="{{ asset('js/omega/omegaPlugin.js') }}" defer></script>
    <script src="{{ asset('js/omega/omegaPluginMvc.js') }}" defer></script>

    <!--<script src="{{ 's'/*asset('Url::Action('language', 'loadforjs')*/ }}" defer></script>-->
    <script src="{{ asset('assets/js/jquery-2.0.3.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/jquery.ui.touch-punch.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/omega.admin.js') }}" defer></script>
    <script src="{{ asset('assets/js/jquery.growl.js') }}" defer></script>
    <script src="{{ asset('assets/js/jquery.finger.js') }}" defer></script>
    <script src="{{ asset('assets/js/metisMenu.js') }}" defer></script>
    <script src="{{ asset('assets/js/sb-admin-2.js') }}" defer></script>
    <script src="{{ asset('assets/js/jquery.rsExplorer.js') }}" defer></script>
    <script src="{{ asset('assets/js/jquery.rsMediaChooser.js') }}" defer></script>
    <script src="{{ asset('assets/js/jquery.rsModuleChooser.js') }}" defer></script>
    <script src="{{ asset('assets/js/plupload.full.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/summernote/summernote.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/word_entity_scrubber.js') }}" defer></script>
    <script src="{{ asset('assets/js/bootstrap3-editable/js/bootstrap-editable.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/bootstrap3-datepicker/js/bootstrap-datepicker.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/bootstrap-iconpicker/js/iconset/iconset-fontawesome-4.3.0.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/bootstrap-iconpicker/js/bootstrap-iconpicker.min.js') }}" defer></script>
    <!--<script src="{{ 's'/*asset('Url::Action('js', 'loadmain'))*/ }}" defer></script>-->


    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.growl.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/metisMenu.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.css') }}" rel="stylesheet">
    <link href="{{ asset('js/summernote/summernote.css') }}" rel="stylesheet">
    <link href="{{ asset('js/bootstrap3-editable/css/bootstrap-editable.css') }}" rel="stylesheet">
    <link href="{{ asset('js/bootstrap3-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('js/bootstrap-iconpicker/css/bootstrap-iconpicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/omega.custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/omega.admin.css') }}" rel="stylesheet">


    <!--[if lt IE 9]>
    <script src="{{ asset('js/html5shiv.js') }}"></script>
    <script src="{{ asset('js/respond.min.js') }}"></script>
    <![endif]-->
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">{{ __('Toggle nav') }}</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ route('public') }}" title="Back to the site">TODO</a>
            </div>
            <div class="nav navbar-top-links navbar-right">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="fr" title="" />&nbsp;&nbsp;<i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu lang">

                            <li>
                                <a href="#">
                                    <img src="" title="fr" />&nbsp;&nbsp;Fracais
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href=""><i class="fa fa-male"></i> {{ __('Profile') }}</a>
                            </li>
                            <li><a href=""><i class="fa fa-lock"></i> {{ __('Logout') }}</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search" style="padding:0px">
                            <a href="">
                                <div class="userAvatarContainer-mini">
                                    <!--echo OmegaUtil::getCurrentUserAvatar();-->
                                </div>
                                <span class="userAvatarContainer-mini-username">
									<span class="bold"><!--echo OmegaUtil::getCurrentUserName()--></span><br />
									<span><!--echo $_SESSION['login'];--></span>
							    </span>
                            </a>
                        </li>

                        {!! add_action('', 'glyphicon glyphicon-th', __('Dashboard')) !!}
                        {!! add_action('', 'glyphicon glyphicon-cog',  __('Settings')) !!}

                    </ul>
                </div>
            </div>
        </nav>
        <div id="page-wrapper">
            <div class="container-fluid">

                @yield('content')

            </div>
        </div>
    </div>
</body>
</html>



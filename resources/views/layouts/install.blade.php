<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Omega CMS installation">
    <meta name="author" content="Roh Sylvain">

    <title>OmegaCMS | {{ __('Install') }}</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/omega.install.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/omega.custom.css') }}" rel="stylesheet">

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <script src="{{ asset('/js/jquery-2.0.3.min.js') }}"></script>
    <script src="{{ asset('/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/js/omega.install.js') }}"></script>

    <!--[if lt IE 9]>
    <script src="{{ asset('/js/html5shiv.js') }}"></script>
    <script src="{{ asset('/js/respond.min.js') }}"></script>
    <![endif]-->
</head>
<body>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1 class="panel-title">@yield('title')</h1>
            </div>
            <div class="panel-body">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
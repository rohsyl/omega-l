<!DOCTYPE HTML>
<!--
	Hielo by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html lang="{{ Entity::LangSlug() }}">
<head>

    <title>{{ Entity::Site()->name }} - {{ Entity::Page()->name }}</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    {!! OmegaUtils::renderMeta() !!}

    <!-- OmegaCMS assets -->
    {!! OmegaUtils::renderOmegaAssets() !!}

    <!-- Styles -->
    <link href="{{ theme_asset('css/main.css') }}" rel="stylesheet"/>

    <!-- Scripts -->

    <script src="{{ theme_asset('js/jquery.scrollex.min.js') }}"></script>
    <script src="{{ theme_asset('js/skel.min.js') }}"></script>
    <script src="{{ theme_asset('js/util.js') }}"></script>
    <script src="{{ theme_asset('js/main.js') }}"></script>

    {!! OmegaUtils::renderDependencies() !!}
</head>
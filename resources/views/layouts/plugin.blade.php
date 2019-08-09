@extends('layouts.app')

@section('content')
    @hasSection('plugin_title')
        <h1 class="page-header">@yield('plugin_title')</h1>
    @else
        @if(isset($meta))
            <h1 class="page-header">{{ $meta->getTitle() }}</h1>
        @endif
    @endif
    @yield('plugin_content')
@endsection
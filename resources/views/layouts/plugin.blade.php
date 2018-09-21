@extends('layouts.app')

@section('content')
    <h1 class="page-header">{{ $meta->getTitle() }}</h1>
    @yield('plugin_content')
@endsection
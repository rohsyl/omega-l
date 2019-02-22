@extends('layouts.app')


@section('content')
    <h1 class="page-header">{{ __('Access denied') }}</h1>
    <p><i class="fa fa-warning"></i> {{ __('You do not have access to the page you requested...') }}</p>
@endsection
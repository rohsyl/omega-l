@extends('layouts.app')

@section('content')
    <br />
    <br />
    <div align="center">
        <p>{{ $message }}?</p>
        <a class="btn btn-primary" href="{{ $routeYes  }}">{{ __('Yes') }}</a>
        <a class="btn btn-default" href="{{ $routeNo }}">{{ __('No') }}</a>
    </div>
@endsection
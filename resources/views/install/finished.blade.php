@extends('layouts.install')

@section('title')
    <strong>Omega CMS Installation</strong> - Finised
@endsection

@section('content')

    <div class="alert alert-success">
        <p><span class="glyphicon glyphicon-ok"></span> {{ __('Database created ...') }}</p>
        <p><span class="glyphicon glyphicon-ok"></span> {{ __('User and basic settings created ...') }}</p>
        <p><span class="glyphicon glyphicon-ok"></span> {{ __('OmegaCMS updated to version ') }} ...</p>
        <p><span class="glyphicon glyphicon-ok"></span> {{ __('OmegaCMS demo data inserted ...') }} </p>
        <p><span class="glyphicon glyphicon-ok"></span> {{ __('OmegaCMS defaults plugins installed ...') }} </p>
        <p><span class="glyphicon glyphicon-ok"></span> <strong>{{ __('Congratulation') }} !</strong> {{ __('You complete the installation process successfully.') }}</p>
    </div>
    <p class="text-center">
        {{ __('Now you can ') }}
        <a href="#" class="btn btn-primary">
            {{ __('login here') }}
        </a>
        {{ __('with your username and your password ...') }}
    </p>
 @endsection

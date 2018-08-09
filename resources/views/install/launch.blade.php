@extends('layouts.install')

@section('title')
    <strong>Omega CMS Installation</strong> - Launch
@endsection

@section('content')

    <h4>{{ __('Basic settings') }}</h4>
    {{ __('Language') 			}} : <br />
    {{ __('Site title') 			}} : <br />
    <hr />
    <h4>{{ __('First user settings') }}</h4>
    {{ __('Login') 				}} : <br />
    {{ __('Password') 			}} : {{ __('Hidden') }}<br />
    {{ __('E-mail') 				}} : <br />
    <hr />

    {{ Form::open(['route' => 'install.do', 'method' => 'POST', 'class' => 'form-horizontal']) }}
        {{ Form::submit(__('Do the installation'), ['class' => 'btn btn-primary btn-block']) }}
    {{ Form::close() }}
    <br />
    <a class="btn btn-default btn-block" href="{{ route('install.siteanduser') }}">{{ __('Back') }}</a>
 @endsection
@extends('layouts.install')

@section('title')
    <strong>Omega CMS Installation</strong> - Launch
@endsection

@section('content')


    <h4 class="page-header">{{ __('Basic settings') }}</h4>
    <dl class="dl-horizontal">
        <dt>{{ __('Language') }}</dt>
        <dd>{{ $lang }}</dd>
        <dt>{{ __('Site title') }}</dt>
        <dd>{{ $title }}</dd>
        <dt>{{ __('Site slogan') }}</dt>
        <dd>{{ $slogan }}</dd>
    </dl>


    <h4 class="page-header">{{ __('First user settings') }}</h4>
    <dl class="dl-horizontal">
        <dt>{{ __('E-mail') }}</dt>
        <dd>{{ $email }}</dd>
        <dt>{{ __('Username') }}</dt>
        <dd>{{ $username }}</dd>
        <dt>{{ __('Password') }}</dt>
        <dd>{{ __('Hidden') }}</dd>
    </dl>

    <hr />

    {{ Form::open(['route' => 'install.do', 'method' => 'POST', 'class' => 'form-horizontal']) }}
        {{ Form::submit(__('Do the installation'), ['class' => 'btn btn-primary btn-block']) }}
    {{ Form::close() }}
    <br />
    <a class="btn btn-default btn-block" href="{{ route('install.siteanduser') }}">{{ __('Back') }}</a>
 @endsection
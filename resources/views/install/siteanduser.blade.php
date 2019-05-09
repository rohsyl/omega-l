@extends('layouts.install')

@section('title')
    <strong>Omega CMS Installation</strong> - Site and User
@endsection

@section('content')

    <div class="alert alert-info">
        {{ __('Please provide the following information.') }}
    </div>

    <hr />
    {{ Form::open(['route' => 'install.step2', 'method' => 'POST', 'class' => 'form-horizontal main-form']) }}
        <div class="form-group">
            {{ Form::label('title', __('Site title :'), ['class' => 'control-label col-sm-3']) }}
            <div class="col-sm-5">
                {{ Form::text('title', $title, ['class' => 'form-control']) }}
                @if ($errors->has('title'))
                    <span class="text-danger" role="alert">
                        <strong>{{ $errors->first('title') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('slogan', __('Site slogan :'), ['class' => 'control-label col-sm-3']) }}
            <div class="col-sm-5">
                {{ Form::text('slogan', $slogan, ['class' => 'form-control']) }}
                @if ($errors->has('slogan'))
                    <span class="text-danger" role="alert">
                            <strong>{{ $errors->first('slogan') }}</strong>
                        </span>
                @endif
            </div>
        </div>

        <hr />

        <div class="form-group">
            {{ Form::label('email', __('E-mail :'), ['class' => 'control-label col-sm-3']) }}
            <div class="col-sm-5">
                {{ Form::email('email', $email, ['class' => 'form-control']) }}
                @if ($errors->has('email'))
                    <span class="text-danger" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('username', __('Administrator username :'), ['class' => 'control-label col-sm-3']) }}
            <div class="col-sm-5">
                {{ Form::text('username', $username, ['class' => 'form-control']) }}
                @if ($errors->has('username'))
                    <span class="text-danger" role="alert">
                        <strong>{{ $errors->first('user') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('password', __('Password :'), ['class' => 'control-label col-sm-3']) }}
            <div class="col-sm-5">
                {{ Form::password('password', ['class' => 'form-control']) }}
                @if ($errors->has('password'))
                    <span class="text-danger" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-5">
                {{ Form::password('password2', ['class' => 'form-control']) }}
                @if ($errors->has('password2'))
                    <span class="text-danger" role="alert">
                        <strong>{{ $errors->first('password2') }}</strong>
                    </span>
                @endif
            </div>
        </div>


    <hr />

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-2">
                <a href="{{ route('install.index') }}" class="btn btn-default btn-block">{{ __('Back') }}</a>
            </div>
            <div class="col-sm-3">
                {{ Form::submit(__('Next'), ['class' => 'btn btn-primary btn-block']) }}
            </div>
        </div>
    {{ Form::close() }}
 @endsection
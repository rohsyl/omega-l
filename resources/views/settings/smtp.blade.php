@extends('layouts.app')

@section('content')
    <h1 class="page-header">{{ __('Settings') }}</h1>
    @include('settings.menu')

    {{ Form::open(['route' => 'admin.settings.smtp.save', 'method' => 'POST', 'class' => 'form-horizontal']) }}
        <div class="form-group">
            {{ Form::label('smtpHost', __('IP or Address'), ['class' => 'control-label col-sm-3']) }}
            <div class="col-sm-5">
                {{ Form::text('smtpHost', $smtp['smtpHost'], ['class' => 'form-control']) }}
                @if ($errors->has('smtpHost'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('smtpHost') }}</strong>
                    </span>
                @else
                    <div class="help-block">
                        {!! __('The IP or address of the SMTP server') !!}
                    </div>
                @endif
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('smtpPort', __('Port'), ['class' => 'control-label col-sm-3']) }}
            <div class="col-sm-5">
                {{ Form::text('smtpPort', $smtp['smtpPort'], ['class' => 'form-control']) }}
                @if ($errors->has('smtpPort'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('smtpPort') }}</strong>
                    </span>
                @else
                    <div class="help-block">
                        {{ __('The port of the SMTP server') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-5">
                <div class="checkbox">
                    <label>
                        {{ Form::hidden('smtpIsSsl', 0) }}
                        {{ Form::checkbox('smtpIsSsl', 1, $smtp['smtpIsSsl']) }}
                        {{ __('Enable SSL/TLS') }}
                    </label>
                </div>
            </div>

        </div>

        <div class="form-group">
            {{ Form::label('smtpAuthUser', __('Username'), ['class' => 'control-label col-sm-3']) }}
            <div class="col-sm-5">
                {{ Form::text('smtpAuthUser', $smtp['smtpAuthUser'], ['class' => 'form-control']) }}
                @if ($errors->has('smtpAuthUser'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('smtpAuthUser') }}</strong>
                    </span>
                @else
                    <div class="help-block">
                        {{ __('The username to connect to the SMTP server') }}
                    </div>
                @endif
            </div>
            <div class="col-sm-4"></div>
        </div>
        <div class="form-group">
            {{ Form::label('smtpAuthPasswd', __('Password'), ['class' => 'control-label col-sm-3']) }}
            <div class="col-sm-5">
                {{ Form::input('password', 'smtpAuthPasswd', $smtp['smtpAuthPasswd'], ['class' => 'form-control']) }}
                @if ($errors->has('smtpAuthPasswd'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('smtpAuthPasswd') }}</strong>
                    </span>
                @else
                    <div class="help-block">
                        {{ __('The password') }}
                    </div>
                @endif
            </div>
            <div class="col-sm-4"></div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-5">
                <input type="submit" name="smtp" class="btn btn-primary btn-block" value="{{ __('Save') }}"/>
            </div>
        </div>
    {{ Form::close() }}
@endsection
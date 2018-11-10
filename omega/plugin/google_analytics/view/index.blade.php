@extends('layouts.plugin')

@section('plugin_content')
    {{ Form::open(['url' => route_plugin('google_analytics', 'save'), 'method' => 'POST', 'class' => 'form-horizontal']) }}

        <div class="form-group">
            <div class="col-md-4 col-md-offset-4">
                <div class="alert alert-info">
                    <strong><i class="fa fa-info-circle"></i> Information</strong>
                    You must <a href="{{ route_plugin('google_analytics', 'help') }}" class="alert-link">place the google analytics module</a> in a module area to enable tracking.
                </div>
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('enable', __('Enable'), ['class' => 'col-md-4 control-label']) }}
            <div class="col-md-4">
                <label class="checkbox-inline" for="enabledAnalytics-0">
                    {{ Form::hidden('enable', 0) }}
                    {{ Form::checkbox('enable', 1, $enable, ['id' => 'enabledAnalytics-0']) }}
                    {{ __('Yes') }}
                </label>
                <div class="help-block">
                    {{ __('Check this to enable Google Analytics Tracking.') }}
                </div>
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('id', __('Tracking ID'), ['class' => 'col-md-4 control-label']) }}
            <div class="col-md-4">
                {{ Form::text('id', $id, ['class' => 'form-control', 'placeholder' => 'UA-xxxxxxxx-x']) }}
                @if($errors->has('id'))
                    <div class="text-danger">
                        {{ $errors->first('id') }}
                    </div>
                @endif
                <div class="help-block">
                    {{ __('Google Analytics Tracking ID (looks like UA-xxxxxxxx-x)') }}
                </div>
            </div>
        </div>

        <br />
        <!-- Button -->
        <div class="form-group">
            <div class="col-md-4 col-md-offset-4">
                <input type="submit" name="googleanalytics_form" value="{{ __('Save') }}" class="btn btn-block btn-primary"/>
            </div>
        </div>
    {{ Form::close() }}

@endsection
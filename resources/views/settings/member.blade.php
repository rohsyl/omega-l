@extends('layouts.app')

@section('content')
    <h1 class="page-header">{{ __('Settings') }}</h1>
    @include('settings.menu')

    {{ Form::open(['route' => 'admin.settings.member.save', 'method' => 'POST', 'class' => 'form-horizontal']) }}
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-5">
                <div class="checkbox">
                    <label>
                        {{ Form::hidden('acceptTermsEnabled', 0) }}
                        {{ Form::checkbox('acceptTermsEnabled', 1, $member['acceptTermsEnabled']) }}
                        {{ __('Enable checkbox "I accept the terms and conditions"') }}
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group">

            {{ Form::label('fileConditions', __('Conditions'), ['class' => 'control-label col-sm-3']) }}
            <div class="col-md-5">
                {{ Form::omMediaChooser('fileConditions', __('Conditions'), $member['conditions']) }}
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-5">
                <input type="submit" name="member" class="btn btn-primary btn-block" value="{{ __('Save') }}"/>
            </div>
        </div>
    {{ Form::close() }}
@endsection
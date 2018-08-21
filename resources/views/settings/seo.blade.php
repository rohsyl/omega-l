@extends('layouts.app')

@section('content')
    <h1 class="page-header">{{ __('Settings') }}</h1>
    @include('settings.menu')
    {{ Form::open(['route' => 'admin.settings.seo.save', 'method' => 'POST', 'class' => 'form-horizontal']) }}
        <div class="form-group">
            {{ Form::label('keywords', __('Keywords'), ['class' => 'control-label col-sm-3']) }}
            <div class="col-sm-5">
                {{ Form::textarea('keywords', $om_seo_keyword, ['class' => 'form-control']) }}
                @if ($errors->has('keywords'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('keywords') }}</strong>
                    </span>
                @else
                    <div class="help-block">
                        {!! __('Keywords help tell search engines what the topic of the page is.<br /> You must separate each keyword with a comma!') !!}
                    </div>
                @endif
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('description', __('Description'), ['class' => 'control-label col-sm-3']) }}
            <div class="col-sm-5">
                {{ Form::textarea('description', $om_seo_description, ['class' => 'form-control']) }}
                @if ($errors->has('description'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('description') }}</strong>
                    </span>
                @else
                    <div class="help-block">
                        {{ __('The meta description is a snippet of up to about 155 characters which summarizes the content of the website') }}
                    </div>
                @endif
            </div>
            <div class="col-sm-4">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-5">
                <input type="submit" name="seo" class="btn btn-primary btn-block" value="{{__('Save') }}"/>
            </div>
        </div>
    {{ Form::close() }}
@endsection
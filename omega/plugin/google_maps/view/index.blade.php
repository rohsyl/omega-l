@extends('layouts.plugin')

@section('plugin_content')

    {{ Form::open(['url' => route_plugin('google_maps', 'save'), 'method' => 'POST', 'class' => 'form-horizontal']) }}

        <div class="form-group">
            <div class="col-md-4 col-md-offset-4">
                <div class="alert alert-info">
                    <strong><i class="fa fa-info-circle"></i> Information</strong>
                    You must <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" class="alert-link">get an API Key</a> and set it down here.
                </div>
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('apikey', __('API Key'), ['class' => 'col-md-4 control-label']) }}
            <div class="col-md-4">
                {{ Form::text('apikey', $apikey, ['placeholder' => __('API Key'), 'class' => 'form-control input-md']) }}
                <div class="help-block">
                    Google Maps JS API Key
                </div>
            </div>
        </div>


        <div class="form-group">
            {{ Form::label('mapstyle', __('Map style'), ['class' => 'col-md-4 control-label']) }}
            <div class="col-md-4">
                {{ Form::textarea('mapstyle', $mapstyle, ['placeholder' => __('Map style'), 'class' => 'form-control', 'rows' => '18']) }}
                <div class="help-block">
                    Google Maps Style as JSON. You can use <a href="https://mapstyle.withgoogle.com/" target="_blank">this tool</a> to create map style.
                </div>
            </div>
        </div>

        <br />
        <!-- Button -->
        <div class="form-group">
            <div class="col-md-4 col-md-offset-4">
                <input type="submit" name="googlemaps_form" value="Save" class="btn btn-block btn-primary"/>
            </div>
        </div>


    {{ Form::close() }}
@endsection
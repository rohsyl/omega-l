@extends('layouts.plugin')

@section('plugin_content')
    {{ Form::open(['url' => route_plugin('social_logo', 'save'), 'method' => 'POST', 'class' => 'form-horizontal']) }}

        <div class="form-group">
            {{ Form::label('title', __('Title'), ['class' => 'control-label col-sm-3']) }}
            <div class="col-sm-5">
                {{ Form::text('title', $title, ['class' => 'form-control']) }}
                @if ($errors->has('title'))
                    <span class="text-danger" role="alert">
                        <strong>{{ $errors->first('title') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <br />

        @foreach($socialNetworks as $key => $sn)
        <div class="form-group">
            {{ Form::label($key, $sn['name'], ['class' => 'control-label col-sm-3']) }}
            <div class="col-md-5">
                {{ Form::text($key, isset($param[$key]) ? $param[$key] : '', ['class' => 'form-control', 'placeholder' => $sn['name']]) }}
            </div>
        </div>
        @endforeach

        <!-- Button -->
        <div class="form-group">
            <div class="col-md-5 col-md-offset-3">
                <input type="submit" name="social_logo" value="Save" class="btn btn-block btn-primary"/>
            </div>
        </div>

    {{ Form::close() }}
@endsection



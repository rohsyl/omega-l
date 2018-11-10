@extends('layouts.plugin')

@section('plugin_content')
  {!! $menu !!}

  {{ Form::open(['url' => route_plugin('news', 'create'), 'method' => 'post', 'class' => 'form-horizontal']) }}


    <div class="form-group">
      {{ Form::label('title', __('Title'), ['class' => 'col-md-4 control-label']) }}
      <div class="col-md-4">
        {{ Form::text('title', null, ['class' => 'form-control', 'placeholder' => __('Title')]) }}
        @if($errors->has('title'))
          <div class="text-danger">
            {{ $errors->first('title') }}
          </div>
        @else
          <div class="text-muted">{{ __('The title of the post') }}</div>
        @endif
      </div>
    </div>


    <div class="form-group">
      <div class="col-md-4 col-md-offset-4">
        <button id="btnAdd" name="btnAdd" class="btn btn-primary">{{ __('Create') }}</button>
      </div>
    </div>

  {{ Form::close() }}

@endsection
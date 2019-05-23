@extends('layouts.plugin')

@section('plugin_content')
    {!! $menu !!}

    {{ Form::open(['url' => route_plugin('news', 'savecategory', ['id' => $category->id]), 'method' => 'post', 'class' => 'form-horizontal main-form']) }}

    <!-- Text input-->
    <div class="form-group">
        {{ Form::label('name', __('Category'), ['class' => 'col-md-4 control-label']) }}
        <div class="col-md-4">
            {{ Form::text('name', $category->name, ['class' => 'form-control', 'placeholder' => __('Category')]) }}
            @if($errors->has('name'))
                <span class="text-danger">
                {{ $errors->first('name') }}
            </span>
            @endif
            <div class="text-muted">{{ __('The name of the category') }}</div>

        </div>
    </div>

    <!-- Button -->
    <div class="form-group">
        <div class="col-md-4 col-md-offset-4">
            <button id="editCategory" name="editCategory" class="btn btn-primary">{{ __('Save') }}</button>
        </div>
    </div>
    {{ Form::close() }}
@endsection
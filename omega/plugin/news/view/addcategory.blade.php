@extends('layouts.plugin')

@section('plugin_content')
    {!!  $menu !!}

    {{ Form::open(['url' => route_plugin('news', 'createcategory'), 'method' => 'post', 'class' => 'form-horizontal']) }}


        <div class="form-group">
            {{ Form::label('name', __('Categorie'), ['class' => 'col-md-4 control-label']) }}
            <div class="col-md-4">
                {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Categorie')]) }}
                @if($errors->has('name'))
                    <div class="text-danger">
                        {{ $errors->first('name') }}
                    </div>
                @else
                    <div class="text-muted">{{ __('The name of the category') }}</div>
                @endif
            </div>
        </div>


        <div class="form-group">
            <div class="col-md-4 col-md-offset-4">
                <button id="addCategory" name="addCategory" class="btn btn-primary">{{ __('Create') }}</button>
            </div>
        </div>

    {{ Form::close() }}
@endsection

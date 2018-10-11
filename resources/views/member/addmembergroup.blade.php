@extends('layouts.app')

@section('content')
    <br /><br />
    {{ Form::open(['url' => route('member.createmembergroup'), 'method' => 'post', 'class' => 'form-horizontal']) }}

        <div class="panel panel-default">
            <div class="panel-heading">
                {{ __('Add member group') }}
            </div>
            <div class="panel-body">
                <div class="form-group">
                    {{ Form::label('name', __('Name'), ['class' => 'col-md-4 control-label']) }}
                    <div class="col-md-4">
                        {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Name')]) }}
                        @if ($errors->has('name'))
                            <span class="text-danger" role="alert">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                        @else
                            <div class="help-block">
                                {{ __('The name of the group') }}
                            </div>
                        @endif
                    </div>

                </div>
                <div class="form-group">
                    <div class="col-md-offset-4 col-md-4">
                        <p><input type="submit" name="addmembergroup" class="btn btn-primary btn-block" value="{{ __('Create') }}" /></p>
                        <p><a href="{{ route('member.index') }}" class="btn btn-default btn-block">{{ __('Cancel') }}</a></p>
                    </div>
                </div>
            </div>
        </div>

    {{ Form::close() }}
@endsection
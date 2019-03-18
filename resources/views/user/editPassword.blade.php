@extends('layouts.app')

@section('content')
    {{ Form::open(['url' => route('user.update.passwd', ['id' => $user->id]), 'method' => 'post', 'class' => 'form-horizontal']) }}


    <div class="page-header">
        <h1>{{ __('Changing password') }}
            <div class="toolbar">
                <button type="submit" class="btn btn-primary" name="updatePassword"><i class="fa fa-save"></i> {{ __('Change password') }}</button>
                <a href="{{ URL::previous() }}" class="btn btn-default">{{ __('Cancel') }}</a>
            </div>
        </h1>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            {{ __('Changing password for ') . $user->username }}
        </div>
        <div class="panel-body">
            <div class="form-group">
                {{ Form::label('password', __('Password'), ['class' => 'col-sm-3 control-label']) }}
                <div class="col-sm-5">
                    {{ Form::password('password', ['class' => 'form-control']) }}
                    @if ($errors->has('password'))
                        <span class="text-danger" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('password2', __('Confirm password'), ['class' => 'col-sm-3 control-label']) }}
                <div class="col-sm-5">
                    {{ Form::password('password2', ['class' => 'form-control']) }}
                    @if ($errors->has('password2'))
                        <span class="text-danger" role="alert">
                                <strong>{{ $errors->first('password2') }}</strong>
                            </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}
@endsection
@extends('layouts.app')

@section('content')
    <h1 class="page-header">{{ __('Edit password') }}</h1>
    {{ Form::open(['url' => route('member.editmember.updatepassword', ['id' => $id]), 'method' => 'post', 'class' => 'form-horizontal']) }}
    <div class="panel panel-default">
        <div class="panel-heading">
            {{ __('Password') }}
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
                    @else
                        <div class="help-block">
                            {{ __('Please use the strongest password as possible. (7 characters).') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-offset-3 col-md-5">
                    <p><input type="submit" class="btn btn-primary btn-block" value="{{ __('Update password') }}" /></p>
                    <p><a href="{{ route('member.editmember', ['id' => $id]) }}" class="btn btn-default btn-block">{{ __('Cancel') }}</a></p>
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}
@endsection
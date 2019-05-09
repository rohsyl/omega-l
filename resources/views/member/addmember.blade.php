@extends('layouts.app')

@section('content')
    <br />
    <br />
    {{ Form::open(['url' => route('member.createmember'), 'method' => 'post', 'class' => 'form-horizontal main-form']) }}
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ __('Add member') }}
            </div>
            <div class="panel-body">

                <!-- Text input-->
                <div class="form-group">
                    {{ Form::label('username', __('Username'), ['class' => 'col-md-3 control-label']) }}
                    <div class="col-md-5">
                        {{ Form::text('username', null, ['class' => 'form-control', 'placeholder' => __('Username')]) }}
                        @if ($errors->has('username'))
                            <span class="text-danger" role="alert">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                        @else
                            <span class="help-block">
                                {{ __('Username can\'t be changed') }}
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    {{ Form::label('email', __('E-mail'), ['class' => 'col-md-3 control-label']) }}
                    <div class="col-md-5">
                        {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => __('E-mail')]) }}
                        @if ($errors->has('email'))
                            <span class="text-danger" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>


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
                        <p><input type="submit" name="addmember" class="btn btn-primary btn-block" value="{{ __('Create') }}" /></p>
                        <p><a href="{{ route('member.index') }}" class="btn btn-default btn-block">{{ __('Cancel') }}</a></p>
                    </div>
                </div>
            </div>
        </div>
    {{ Form::close() }}
@endsection
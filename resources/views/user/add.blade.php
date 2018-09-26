@extends('layouts.app')

@section('content')
    {{ Form::open(['url' => route('user.create'), 'method' => 'POST', 'class' => 'form-horizontal']) }}


        <div class="page-header">
            <h1>{{ __('Add user') }}
                <div class="toolbar">
                    <button type="submit" class="btn btn-primary" name="addUserBtn"><i class="fa fa-user-plus"></i> {{ __('Create') }}</button>
                    <a href="{{ URL::previous() }}" class="btn btn-default">{{ __('Cancel') }}</a>
                </div>
            </h1>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                {{ __('Informations') }}
            </div>
            <div class="panel-body">
                <div class="form-group">
                    {{ Form::label('username', __('Username'), ['class' => 'col-sm-3 control-label']) }}
                    <div class="col-sm-5">
                        {{ Form::text('username', null, ['class' => 'form-control']) }}
                        @if ($errors->has('username'))
                            <span class="text-danger" role="alert">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                        @else
                            <div class="help-block">
                                {{ __('You will use this to log in.') }}<br />
                                {{ __('Username can only include alphanumeric characters, underscores and at sign.') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('email', __('E-mail'), ['class' => 'col-sm-3 control-label']) }}
                    <div class="col-sm-5">
                        {{ Form::text('email', null, ['class' => 'form-control']) }}
                        @if ($errors->has('email'))
                            <span class="text-danger" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('fullname', __('Fullname'), ['class' => 'col-sm-3 control-label']) }}
                    <div class="col-sm-5">
                        {{ Form::text('fullname', null, ['class' => 'form-control']) }}
                        @if ($errors->has('fullname'))
                            <span class="text-danger" role="alert">
                                <strong>{{ $errors->first('fullname') }}</strong>
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
            </div>
        </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ __('Rights') }}
                </div>
                <div class="panel-body">
                    <div style="height : 300px; overflow-y : scroll">
                        <table class="table">
                            <tr>
                                <th></th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Description') }}</th>
                            </tr>
                            @foreach($rights as $r)
                                <tr>
                                    <td>
                                        {{ Form::checkbox('rights[]', $r->id) }}
                                    </td>
                                    <td>{{ $r->getNiceName() }}</td>
                                    <td>{{ $r->description }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                {{ __('Groups') }}
            </div>
            <div class="panel-body">
                <div style="max-height : 300px; overflow-y : scroll">
                    <table class="table">
                        <tr>
                            <th></th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Description') }}</th>
                        </tr>
                        @foreach($groups as $g)
                            <tr>
                                <td>
                                    {{ Form::checkbox('groups[]', $g->id) }}
                                </td>
                                <td>{{ $g->getNiceName() }}</td>
                                <td>{{ $g->description }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>

    {{ Form::close() }}
@endsection
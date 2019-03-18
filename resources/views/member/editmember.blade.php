@extends('layouts.app')

@section('content')
    <h1 class="page-header">{{ __('Edit member') }}</h1>
    {{ Form::open(['url' => route('member.updatemember', ['id' => $member->id]), 'method' => 'post', 'class' => 'form-horizontal']) }}
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ __('Informations') }}
                </div>
                <div class="panel-body">

                    <!-- Text input-->
                    <div class="form-group">
                        {{ Form::label('username', __('Username'), ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-5">
                            {{ Form::text('username', $member->username, ['class' => 'form-control', 'placeholder' => __('Username'), 'disabled']) }}
                            <span class="help-block">
                                {{ __('Username can\'t be changed') }}
                                </span>
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        {{ Form::label('email', __('E-mail'), ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-5">
                            {{ Form::text('email', $member->email, ['class' => 'form-control', 'placeholder' => __('E-mail')]) }}
                            @if ($errors->has('email'))
                                <span class="text-danger" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ __('Actions') }}
                </div>
                <div class="panel-body">
                    <p><input type="submit" name="editmember" class="btn btn-primary btn-block" value="{{ __('Save') }}" /></p>
                    <p><a class="btn btn-warning btn-block"  href="{{ route('member.editmember.password', ['id' => $member->id]) }}" >{{ __('Change password') }}</a></p>
                    @if(has_right('member_delete'))
                        <p><a class="btn btn-danger btn-block"  href="{{ route('member.deletemember', ['id' => $member->id])}}" >{{ __('Delete') }}</a></p>
                    @endif
                    <p><a href="{{ route('member.index') }}" class="btn btn-default btn-block">{{ __('Cancel') }}</a></p>
                </div>
            </div>
            @if(!$member->isValid)
                <div class="alert alert-warning">
                    <strong>{{ __('This member is awaiting e-mail validation.') }}</strong>
                    <p>{{--
                        {{ $url = Url::Combine(ABSPATH, 'module/member/validatemember?hash='.$member->membValidationHash); }}
                        {{ sprintf(__('You can manually validate this member by following this %1$s link %2$s', true), '<a href="'.$url.'">','</a>') }}
                    --}}</p>
                </div>
            @endif

            @if($member->membLostPasswordHash != null)
                <div class="alert alert-warning">
                    <strong>{{ __('This member need password modification.') }}</strong>
                    <p>{{--
                        {{ $url = Url::Combine(ABSPATH, 'module/member/changepassword?hash='.$member->membLostPasswordHash); }}
                        {{ echo sprintf(__('You can manually change the password by following this %1$s link %2$s', true), '<a href="'.$url.'">','</a>') }}
                        --}}
                    </p>
                </div>
            @endif
        </div>
    </div>
    {{ Form::close() }}
@endsection
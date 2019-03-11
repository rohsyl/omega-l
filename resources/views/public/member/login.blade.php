<div class="om-wrapper">
    {{ Form::open(['url' => route('public.member.doLogin'), 'method' => 'post']) }}
        <br />
        <br />
        <div class="member-login-box">
            <div class="member-login-form">


                @if($errors->has('member_auth_errors'))
                    <div class="alert alert-danger">
                            {{ $errors->first('member_auth_errors') }}
                    </div>
                @endif

                <!-- Text input-->
                <div class="form-group">
                    {{ Form::label('username', __('Username'), ['class' => 'control-label']) }}
                    {{ Form::text('username', null, ['class' => 'form-control', 'placeholder' => __('Username')]) }}
                    @if(isset($errors) && $errors->has('username'))
                        <span class="text-danger">
                            {{ $errors->first('username') }}
                        </span>
                    @endif
                </div>

                <!-- Password input-->
                <div class="form-group">
                    {{ Form::label('password', __('Password'), ['class' => 'control-label']) }}
                    {{ Form::password('password', ['class' => 'form-control']) }}
                    @if(isset($errors) && $errors->has('password'))
                        <span class="text-danger">
                            {{ $errors->first('password') }}
                        </span>
                    @endif
                </div>


                <!-- Button -->
                <div class="form-group">
                    <button id="login" name="login" type="submit" class="btn btn-primary btn-block">{{ __('Log in') }}</button>
                </div>
            </div>
            <div class="member-login-footer">
                <a href="" class="btn btn-default btn-xs">{{ __('Sign up') }}</a><br />
                <a href="" class="btn btn-default btn-xs">{{ __('Forgot your password ?') }}</a>
            </div>
        </div>
    {{ Form::close() }}
</div>

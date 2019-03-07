<div class="om-wrapper">
    {{ Form::open(['url' => route('public.member.login'), 'method' => 'post']) }}
        <div class="member-login-box">
            <div class="member-login-form">
                <!-- Text input-->
                <div class="form-group">
                    <label class="control-label" for="pseudo">{{ __('Login') }}</label>
                    <input id="pseudo" name="pseudo" placeholder="{{ __('Login') }}" class="form-control input-md" type="text">
                </div>

                <!-- Password input-->
                <div class="form-group">
                    <label class="control-label" for="password">{{ __('Password') }}</label>
                    <input id="password" name="password" placeholder="{{ __('Password') }}" class="form-control input-md" type="password">
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

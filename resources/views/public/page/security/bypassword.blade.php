<div class="om-wrapper">
    <div class="component-container page-secured-content">
        <p>{{ $message }}</p>
        {{ Form::open(['url' => Request::url(), 'method' => 'post', 'class' => 'main-form']) }}
            <p align="center">
                {{ Form::password('securityPassword', null, ['placeholder' => __('Password')]) }}
                <input style="margin-top : 5px;" type="submit" value="Login" name="securityDoLogin" />
            </p>
        {{ Form::close() }}
        @if(isset($error))
        <p class="text-danger">
            {{ $error }}
        </p>
        @endif
    </div>
</div>
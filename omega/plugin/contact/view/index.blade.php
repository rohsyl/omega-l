@extends('layouts.plugin')

@section('plugin_content')

    {{ Form::open(['url' => route_plugin('contact', 'save'), 'method' => 'post', 'class' => 'form-horizontal main-form']) }}


    <div>

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" id="tabs-contact" role="tablist">
            <li role="presentation" class="active"><a href="#info" aria-controls="info" role="tab" data-toggle="tab">{{ __('Informations') }}</a>
            </li>
            <li role="presentation"><a href="#tab-mail" aria-controls="tab-mail" role="tab" data-toggle="tab">{{ __('Contact form') }} </a>
            </li>
        </ul>

        <br/>
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="info">


                <div class="form-group">
                    {{ Form::label('logo', __('Contact logo'), ['class' => 'control-label col-md-4']) }}
                    <div class="col-md-4">
                        {{ Form::omMediaChooser('logo', __('Contact logo'), isset($paramData['contactLogo']) ? $paramData['contactLogo'] : null) }}
                    </div>
                </div>


                <div class="form-group">
                    {{ Form::label('displayLogo', __('Display logo'), ['class' => 'control-label col-md-4']) }}
                    <div class="col-sm-4">
                        <div class="checkbox">
                            <label>
                                {{ Form::hidden('displayLogo', 0) }}
                                {{ Form::checkbox('displayLogo', 1, isset($paramData['displayLogo']) ? $paramData['displayLogo'] : false) }}
                                {{ __('Yes') }}
                            </label>
                        </div>

                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('phone', __('Phone'), ['class' => 'control-label col-md-4']) }}
                    <div class="col-md-4">
                        {{ Form::text('phone', isset($paramData['phone']) ? $paramData['phone'] : '', ['class' => 'form-control', 'placeholder' => __('Phone')]) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('mobile', __('Mobile'), ['class' => 'control-label col-md-4']) }}
                    <div class="col-md-4">
                        {{ Form::text('mobile', isset($paramData['mobile']) ? $paramData['mobile'] : '', ['class' => 'form-control', 'placeholder' => __('Mobile')]) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('fax', __('Fax'), ['class' => 'control-label col-md-4']) }}
                    <div class="col-md-4">
                        {{ Form::text('fax', isset($paramData['fax']) ? $paramData['fax'] : '', ['class' => 'form-control', 'placeholder' => __('Fax')]) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('mail_info', __('Mail'), ['class' => 'control-label col-md-4']) }}
                    <div class="col-md-4">
                        {{ Form::text('mail_info', isset($paramData['mail_info']) ? $paramData['mail_info'] : '', ['class' => 'form-control', 'placeholder' => __('Mail')]) }}
                        @if($errors->has('mail_info'))
                            <span class="text-danger">
                                {{ $errors->first('mail_info') }}
                            </span>
                        @endif
                    </div>
                </div>


                <div class="form-group">
                    {{ Form::label('name', __('Name'), ['class' => 'control-label col-md-4']) }}
                    <div class="col-md-4">
                        {{ Form::text('name', isset($paramData['name']) ? $paramData['name'] : '', ['class' => 'form-control', 'placeholder' => __('Name')]) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('street', __('Street'), ['class' => 'control-label col-md-4']) }}
                    <div class="col-md-4">
                        {{ Form::text('street', isset($paramData['street']) ? $paramData['street'] : '', ['class' => 'form-control', 'placeholder' => __('Street')]) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('npa', __('NPA'), ['class' => 'control-label col-md-4']) }}
                    <div class="col-md-4">
                        {{ Form::text('npa', isset($paramData['npa']) ? $paramData['npa'] : '', ['class' => 'form-control', 'placeholder' => __('NPA')]) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('locality', __('Locality'), ['class' => 'control-label col-md-4']) }}
                    <div class="col-md-4">
                        {{ Form::text('locality', isset($paramData['locality']) ? $paramData['locality'] : '', ['class' => 'form-control', 'placeholder' => __('Locality')]) }}
                    </div>
                </div>


            </div>


            <div role="tabpanel" class="tab-pane" id="tab-mail">



                <div class="form-group">
                    {{ Form::label('mail', __('Mail'), ['class' => 'control-label col-md-4']) }}
                    <div class="col-md-4">
                        {{ Form::text('mail', isset($paramData['mail']) ? $paramData['mail'] : '', ['class' => 'form-control', 'placeholder' => __('Mail')]) }}
                        <div class="help-block">
                            {{ __('Message sent with the contact form will be send to this mail address') }}
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('conf_message', __('Confirmation message'), ['class' => 'control-label col-md-4']) }}
                    <div class="col-md-4">
                        {{ Form::textarea('conf_message', isset($paramData['conf_message']) ? $paramData['conf_message'] : '', ['class' => 'form-control', 'placeholder' => __('Confirmation message')]) }}
                        <div class="help-block">
                            {{ __('Message displayed to the user after he have sent his message') }}
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-4">
                        <hr />
                        <h4>{{ __('reCAPTCHA') }}</h4>
                        <div class="alert alert-info">
                            https://www.google.com/recaptcha/admin#list
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('is_antispam', __('Enable reCAPTCHA'), ['class' => 'control-label col-md-4']) }}
                    <div class="col-sm-4">
                        <div class="checkbox">
                            <label>
                                {{ Form::hidden('is_antispam', 0) }}
                                {{ Form::checkbox('is_antispam', 1, isset($paramData['is_antispam']) ? $paramData['is_antispam'] : false) }}
                                {{ __('Yes') }}
                            </label>
                        </div>

                    </div>
                </div>


                <div class="form-group">
                    {{ Form::label('key_site', __('Site key'), ['class' => 'control-label col-md-4']) }}
                    <div class="col-md-4">
                        {{ Form::text('key_site', isset($paramData['key_site']) ? $paramData['key_site'] : '', ['class' => 'form-control', 'placeholder' => __('Site key')]) }}
                        <div class="help-block">
                            {{ __('This key is used to invoke reCAPTCHA service on your site') }}
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('key_secret', __('Secret key'), ['class' => 'control-label col-md-4']) }}
                    <div class="col-md-4">
                        {{ Form::text('key_secret', isset($paramData['key_secret']) ? $paramData['key_secret'] : '', ['class' => 'form-control', 'placeholder' => __('Secret key')]) }}
                        <div class="help-block">
                            {{ __('This key authorizes communication between your application backend and the reCAPTCHA server to verify the user\'s response. Keep this key secret.') }}
                        </div>
                    </div>
                </div>

            </div>


        </div>

    </div>

    <!-- Button -->
    <div class="form-group">
        <div class="col-md-offset-4 col-md-4">
            <button id="contactForm" name="contactForm" type="submit"
                    class="btn btn-primary">{{ __('Save') }}</button>
        </div>
    </div>

    {{ Form::close() }}
@endsection

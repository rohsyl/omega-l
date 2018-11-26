<div class="plugin-contact-container">

    @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
            @php session()->forget('success') @endphp
        </div>
    @endif

    {{ Form::open(['url' => url()->current(), 'method' => 'post', 'class' => 'form'])  }}
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => __('Name') . '*']) }}
                    @if($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::text('mail', old('mail'), ['class' => 'form-control', 'placeholder' => __('E-mail') . '*']) }}
                    @if($errors->has('mail'))
                        <span class="text-danger">{{ $errors->first('mail') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::text('phone', old('phone'), ['class' => 'form-control', 'placeholder' => __('Phone')]) }}
                    @if($errors->has('phone'))
                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                {{ Form::label('message', __('Message')     . '*', ['class' => 'form-label']) }}
                <div class="form-group">
                    {{ Form::textarea('message', old('message'), ['class' => 'form-control']) }}
                    @if($errors->has('message'))
                        <span class="text-danger">{{ $errors->first('message') }}</span>
                    @endif
                </div>
            </div>
        </div>
        @if($isAntispam)
            @if($errors->has('recaptcha'))
                <span class="text-danger">{{ $errors->first('recaptcha') }}</span>
            @endif
            <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response"/>
            <script>
                grecaptcha.ready(function() {
                    grecaptcha.execute('{{ $key_site }}', {action: 'contactpage'}).then(function (token) {
                        document.getElementById('g-recaptcha-response').value = token;
                    });
                });
            </script>
        @endif
        <p class="text-right">
            <input type="submit" name="contactForm" class="btn btn-primary" value="Envoyer"/>
        </p>
    {{ Form::close() }}
</div>
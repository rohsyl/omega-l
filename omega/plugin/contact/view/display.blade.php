<div class="plugin-contact-container">

    <form action="" method="POST" class="form">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <input class="form-control" value="{{ old('name') }}" type="text" name="name" placeholder="Nom"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <input class="form-control" value="{{ old('mail') }}" type="text" name="mail" placeholder="E-mail"/>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <input class="form-control" value="{{ old('phone') }}" type="text" name="phone" placeholder="Téléphone"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div>Message :</div>
                <div class="form-group">
                    <textarea class="form-control" name="message">{{ old('message') }}</textarea>
                </div>
            </div>
        </div>
        @if($isAntispam)
        <div class="row">
            <div class="col-md-6">
                <div>Captcha: <br /><img src="{{ session('captcha')['image_src'] }}" /></div>
                <div class="form-group">
                    <input  type="text" name="result" class="form-control">
                </div>
            </div>
        </div>
        @endif
        <p class="text-right">
            <input type="submit" name="contactForm" class="btn btn-primary" value="Envoyer"/>
        </p>
    </form>
</div>
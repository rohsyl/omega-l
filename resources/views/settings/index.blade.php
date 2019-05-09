@extends('layouts.app')

@section('content')
    <h1 class="page-header">{{ __('Settings') }}</h1>
    @include('settings.menu')
    {{ Form::open(['route' => 'admin.settings.general.save', 'method' => 'POST', 'class' => 'form-horizontal main-form']) }}

        <div class="form-group">
            {{ Form::label('title', __('Title'), ['class' => 'control-label col-sm-3']) }}
            <div class="col-sm-5">
                {{ Form::text('title', $generalConfig['om_site_title'], ['class' => 'form-control']) }}
                @if ($errors->has('title'))
                    <span class="text-danger" role="alert">
                        <strong>{{ $errors->first('title') }}</strong>
                    </span>
                @else
                    <div class="help-block">
                        {{ __('The title of your website') }}
                    </div>
                @endif
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('slogan', __('Slogan'), ['class' => 'control-label col-sm-3']) }}
            <div class="col-sm-5">
                {{ Form::text('slogan', $generalConfig['om_site_slogan'], ['class' => 'form-control']) }}
                @if ($errors->has('slogan'))
                    <span class="text-danger" role="alert">
                        <strong>{{ $errors->first('slogan') }}</strong>
                    </span>
                @else
                    <div class="help-block">
                        {{ __('The slogan of your website') }}
                    </div>
                @endif
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('web_adress', __('Web address'), ['class' => 'control-label col-sm-3']) }}
            <div class="col-sm-5">
                {{ Form::text('web_adress', $generalConfig['om_web_adress'], ['class' => 'form-control']) }}
                @if ($errors->has('web_adress'))
                    <span class="text-danger" role="alert">
                        <strong>{{ $errors->first('web_adress') }}</strong>
                    </span>
                @else
                    <div class="help-block">
                        {{ __('The URL that you use to connect to Omega') }}
                    </div>
                @endif
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('home', __('Home page'), ['class' => 'control-label col-sm-3']) }}
            <div class="col-sm-5">
                {{ Form::select('home', $pages, $generalConfig['om_home_page_id'], ['class' => 'form-control']) }}
                @if ($errors->has('home'))
                    <span class="text-danger" role="alert">
                        <strong>{{ $errors->first('home') }}</strong>
                    </span>
                @else
                    <div class="help-block">
                        {{ __('The home page is the webpage that serves as the starting point of website') }}
                    </div>
                @endif
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('lang', __('Default back-office language'), ['class' => 'control-label col-sm-3']) }}
            <div class="col-sm-5">
                <div class="row">
                    @foreach($backLanguages as $lang)
                        <?php $checked = $currentBackLanguage->getTwoLetterId() == $lang->getTwoLetterId() ? 'checked' : '' ?>
                    <div class="col-sm-4">
                        <input {{ $checked }} type="radio" name="lang" value="{{ $lang->getTwoLetterId() }}" id="{{ $lang->getTwoLetterId() }}" />
                        <label for="{{ $lang->getTwoLetterId() }}">
                            <img width=50 height=30 src="{{ $lang->getFatFlag() }}" alt="{{ $lang->getName() }}" />
                        </label>
                    </div>
                    @endforeach
                </div>
                @if ($errors->has('lang'))
                    <span class="text-danger" role="alert">
                        <strong>{{ $errors->first('lang') }}</strong>
                    </span>
                @else
                    <div class="help-block">
                        {{ __('The default language used in the back-office of your website') }}
                    </div>
                @endif
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-5">
                <input type="submit" name="general" class="btn btn-primary btn-block" value="{{ __('Save') }}"/>
            </div>
        </div>

    {{ Form::close() }}
@endsection
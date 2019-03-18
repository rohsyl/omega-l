@extends('layouts.app')

@push('scripts')
    <script src="{{ asset('js/omega/admin/theme/detail.js') }}"></script>
@endpush

@section('content')
    <h1 class="page-header">{{ $theme->title }}</h1>
    <div class="row" id="detail-theme" data-theme="{{ $theme->name }}">
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ __('Informations') }}
                </div>
                <div class="panel-body">
                    <p><strong>{{ __('Title') }}</strong><br />{{ $theme->title }}</p>
                    @if(!empty($theme->description))
                    <p><strong>{{ __('Description') }}</strong><br />{{ $theme->description }}</p>
                    @endif
                    @if(!empty($theme->website))
                    <p>
                        <a href="{{ $theme->website }}" target="_blank" class="btn btn-default"><i class="fa fa-eye"></i> {{ __('Website') }}</a>
                    </p>
                    @endif
                </div>
            </div>
            @if($isCurrent && has_right(''))
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ __('Assets') }}
                </div>
                <div class="panel-body">
                    <div class="alert alert-warning">
                        <p>
                            <strong>{{ __('Warning !') }}</strong><br />
                            {!!
                                __('Publishing the assets will override the files under :path_public by the originals assets in the :path_theme', [
                                    'path_public' => '<code>/public/theme/</code>',
                                    'path_theme' => '<code>/omega/theme/'.$theme->name.'/assets/</code>'
                                ])
                            !!}
                        </p>
                        <br />
                        <a href="{{ route('theme.publish', ['name' => $theme->name]) }}" class="btn btn-warning">Publish</a>
                    </div>
                </div>
            </div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ __('Module area') }}

                    @if(has_right('theme_modulearea'))
                        <a href="#" id="btnAddModulearea" class="btn btn-xs btn-primary" style="float:right;">{{ __('Add') }}</a>
                    @endif
                </div>
                <div class="panel-body" id="moduleareaList">
                    {{ __('Loading...') }}
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ __('Template') }}
                </div>
                <div class="panel-body">
                    @foreach($templates as $t)
                        <p>{{ prettify_text(without_ext(without_ext($t))) }}</p>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ __('Preview') }}
                    <a href="{{-- echo Url::CombAndAbs(ABSPATH, Url::Link('library/demo.php', array('theme' => $theme->themeName))) --}}" class="btn btn-xs btn-default" style="float: right;" target="_blank">
                        {{ __('Open demo in a new tab') }}
                    </a>
                </div>
                <div class="panel-body">
                    <iframe src="{{-- echo Url::CombAndAbs(ABSPATH, Url::Link('library/demo.php', array('theme' => $theme->themeName))) --}}" width="100%" height="800px"></iframe>
                </div>
            </div>
        </div>
    </div>
@endsection
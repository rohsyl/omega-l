
@extends('layouts.plugin')

@section('plugin_content')
    <dl>
        <dt>{{ __('Name') }}</dt>
        <dd>{{ $meta->getName() }}</dd>
        <dt>{{ __('Title') }}</dt>
        <dd>{{ $meta->getTitle() }}</dd>
        <dt>{{ __('Author') }}</dt>
        <dd>{{ $meta->getAuthor() }}</dd>
        <dt>{{ __('Version') }}</dt>
        <dd>{{ $meta->getVersion() }}</dd>
        <dt>{{ __('Description') }}</dt>
        <dd>{{ $meta->getDescription() }}</dd>
    </dl>

    @if(has_right('plugin_publish'))
        <h3 class="page-header">Publish</h3>
        <div class="alert alert-warning">
            <p>
                <strong>{{ __('Warning !') }}</strong><br />
                {!!
                    __('Publishing the assets will override the files under :path_public by the originals assets in the :path_theme', [
                        'path_public' => '<code>/public/plugin/'.$meta->getName().'/</code>',
                        'path_theme' => '<code>/omega/plugin/'.$meta->getName().'/assets/</code>'
                    ])
                !!}
            </p>
            <br />
            <a href="{{ route('admin.plugins.publish', ['name' => $meta->getName()]) }}" class="btn btn-warning">Publish</a>
        </div>
    @endif
@endsection
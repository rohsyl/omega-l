
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
@endsection
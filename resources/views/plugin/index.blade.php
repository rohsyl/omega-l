@extends('layouts.app')

@section('content')
    <h1 class="page-header">{{ __('Plugin') }}</h1>
    <table class="table table-hover">
        <tr>
            <th>{{ __('Name') }}</th>
            <th>{{ __('Author') }}</th>
            <th>{{ __('Version') }}</th>
            <th>{{ __('Description') }}</th>
            <th>{{ __('Actions') }}</th>
        </tr>


        @foreach($installed as $meta)
        <tr>
            <td><a href="{{ route('admin.plugins.run', ['name' => $meta->getName(), 'action' => 'index']) }}">{{ $meta->getTitle() }}</a></td>
            <td>{{ $meta->getAuthor() }}</td>
            <td>{{ $meta->getVersion() }}</td>
            <td>{{ $meta->getDescription() }}</td>
            <td>
                <span class="actions">
                    <a href="{{ route('admin.plugins.settings', ['name' => $meta->getName() ]) }}">{{ __('Settings') }}</a>
                    @if(has_right('plugin_install'))
                    |
                    <a href="{{  route('admin.plugins.uninstall', ['name' => $meta->getName() ]) }}" class="text-danger">{{ __('Uninstall') }}</a>
                    @endif
                </span>
            </td>
        </tr>
        @endforeach

        @if(has_right('plugin_install'))
        @foreach($uninstalled as $meta)
            <tr class="warning">
                <td>{{ $meta->getTitle() }}</td>
                <td>{{ $meta->getAuthor() }}</td>
                <td>{{ $meta->getVersion() }}</td>
                <td>{{ $meta->getDescription() }}</td>
                <td>
                    <span class="actions">
                        <a href="{{ route('admin.plugins.install', ['name' => $meta->getName() ]) }}">{{ __('Install') }}</a>
                    </span>
                </td>
            </tr>
        @endforeach
        @endif
    </table>
@endsection
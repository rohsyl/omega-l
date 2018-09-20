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

        @foreach($installed as $meta)
        <tr>
            <td><a href="{{ route('admin.plugins.run', ['name' => $meta->getName(), 'action' => 'index']) }}">{{ $meta->getTitle() }}</a></td>
            <td>{{ $meta->getAuthor() }}</td>
            <td>{{ $meta->getVersion() }}</td>
            <td>{{ $meta->getDescription() }}</td>
            <td>
                <span class="actions">
                    <a href="{{  route('admin.plugins.uninstall', ['name' => $meta->getName() ]) }}" class="text-danger">{{ __('Uninstall') }}</a>
                </span>
            </td>
        </tr>
        @endforeach
    </table>
@endsection
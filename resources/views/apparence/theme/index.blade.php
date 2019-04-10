@extends('layouts.app')

@section('content')
    <h1 class="page-header">{{ __('Themes') }}</h1>
    <div class="page-header">
        <h4>{{ __('Installed themes') }}</h4>
    </div>
    <div class="row">
        @forelse($installed as $it)
            @php $used = $it->name == $current; @endphp
        <div class="col-md-3 col-sm-4 col-sm-6">
            <div class="panel panel-{{ $used ? 'green' : 'success' }}">
                <div class="panel-heading">
                    {{ $it->title }}
                </div>
                <div class="panel-body">
                    <p><a class="btn btn-primary btn-block btn-sm" href="{{ route('theme.detail', ['theme' => $it->name]) }}">{{ __('Detail') }}</a></p>
                    @if(!$used)
                        @if(has_right('theme_use'))
                            <p><a class="btn btn-warning btn-block btn-sm" href="{{ route('theme.useit', ['theme' => $it->name]) }}">{{ __('Use it') }}</a></p>
                        @endif
                    @else
                    <p><a class="btn btn-warning btn-block btn-sm disabled" href="#">{{ __('Used') }}</a></p>
                    @endif
                    @if(has_right('theme_install'))
                    <p><a class="btn btn-default btn-block btn-sm" href="{{ route('theme.uninstall', ['theme' => $it->name]) }}">{{ __('Uninstall') }}</a></p>
                    @endif
                </div>
            </div>
        </div>
        @empty
            <p class="text-center">{{ __('There is no installed themes ...') }}</p>
        @endforelse
    </div>

    @if(has_right('theme_install'))
        <br />
        <div class="page-header">
            <h4>{{ __('Availables themes') }}</h4>
        </div>
        <div class="row">
            @forelse ($uninstalled as $name)
                <div class="col-md-3 col-sm-4 col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            {{ $name }}
                        </div>
                        <div class="panel-body">
                            <p><a class="btn btn-success btn-block btn-sm" href="{{ route('theme.install', ['theme' => $name]) }}">{{ __('Install') }}</a></p>
                            {{-- <p><a class="btn btn-default btn-block btn-sm delete" href="{{ route('theme.delete', ['theme' => $name]) }}">{{ __('Delete') }}</a></p>--}}
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center">{{ __('There is no availables themes ...') }}</p>
            @endforelse
        </div>
    @endif
@endsection
@extends('layouts.app')

@section('content')
    <h1 class="page-header">{{ __('Themes') }}</h1>
    <div class="page-header">
        <h4>{{ __('Installed themes') }}</h4>
    </div>
    <div class="row">
        @if(sizeof($installed) == 0)
        <p class="text-center">{{ __('There is no installed themes ...') }}</p>
        @else
            @foreach($installed as $it)
                @php $used = $it->name == $current; @endphp
            <div class="col-md-3 col-sm-4 col-sm-6">
                <div class="panel panel-{{ $used ? 'green' : 'success' }}">
                    <div class="panel-heading">
                        {{ $it->title }}
                    </div>
                    <div class="panel-body">
                        <p><a class="btn btn-primary btn-block btn-sm" href="{{ route('theme.detail', ['theme' => $it->name]) }}">{{ __('Detail') }}</a></p>
                        @if(!$used)
                        <p><a class="btn btn-warning btn-block btn-sm" href="{{ route('theme.useit', ['theme' => $it->name]) }}">{{ __('Use it') }}</a></p>
                        @else
                        <p><a class="btn btn-warning btn-block btn-sm disabled" href="#">{{ __('Used') }}</a></p>
                        @endif
                        <p><a class="btn btn-default btn-block btn-sm" href="{{ route('theme.uninstall', ['theme' => $it->name]) }}">{{ __('Uninstall') }}</a></p>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>
    <br />
    <div class="page-header">
        <h4>{{ __('Availables themes') }}</h4>
    </div>
    <div class="row">
        @if(count($uninstalled) == 0)
            <p class="text-center">{{ __('There is no availables themes ...') }}</p>
        @else
            @foreach ($uninstalled as $name)
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
            @endforeach
        @endif
    </div>
@endsection
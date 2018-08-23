@extends('layouts.app')

@section('content')
    <h1 class="page-header">{{ __('Settings') }}</h1>
    @include('settings.menu')


    <div class="form-horizontal">

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
                <a href="{{ route('admin.settings.advanced.clearCache') }}" class="btn btn-warning btn-block">{{ __('Clear cache') }}</a>

                <div class="help-block">
                    {{ __('Click here to clear the cache.') }}
                </div>
            </div>
        </div>
    </div>
@endsection
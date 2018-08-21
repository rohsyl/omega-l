@extends('layouts.app')

@push('scripts')
    <script src="{{ asset('js/omega/admin/settings/flang.js') }}" defer></script>
@endpush

@section('content')
    <h1 class="page-header">{{ __('Settings') }}</h1>
    @include('settings.menu')
    {{ Form::open(['route' => 'admin.settings.flang.save', 'method' => 'POST', 'class' => 'form-horizontal']) }}


        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-5">
                <div class="checkbox">
                    <label>
                        {{ Form::hidden('flang_enable', 0) }}
                        {{ Form::checkbox('flang_enable', 1, $enableFrontLanguage, ['id' => 'flang_enable']) }}
                        {{ __('Enable multi-langue') }}
                    </label>
                </div>
            </div>
        </div>


        <div class="form-group">
            {{ Form::label('flang_default', __('Default language'), ['class' => 'control-label col-sm-3']) }}
            <div class="col-sm-5">
                {{ Form::select('flang_default', $fallLang, $defaultFrontLanguage, ['class' => 'form-control']) }}
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-5">
                {{ Form::submit(__('Save'), ['class' => 'btn btn-primary btn-block']) }}
            </div>
        </div>
    {{ Form::close() }}

    <br />
    <div id="flangtab">
        {{ $langftable }}
    </div>
@endsection
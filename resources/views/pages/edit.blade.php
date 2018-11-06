@extends('layouts.app')

@push('scripts')
    <script src="{{ asset('js/omega/admin/pages/edit.js') }}"></script>
    <script src="{{ asset('js/omega/admin/pages/edit.langs.js') }}"></script>
@endpush

@section('content')

    <div class="page-edit-form" data-page-id="{{ $page->id }}">
        {{ Form::open(['url' => route('admin.pages.update', ['id' => $page->id])]) }}

            {{ Form::hidden('tab', $tab, ['id' => 'tab']) }}

            <div class="page-header">
                <h2>
                    <i class="fa fa-pencil-square-o"></i> {{ __('Page edition')}}  - {{ $page->name }}
                    @if(!$page->isEnabled)
                        <small>{{ __('This page is disabled') }}</small>
                    @endif

                    <div class="toolbar">
                        <button type="submit" class="btn btn-primary btn-tooltip" title="{{ __('Save') }}" name="getEditPageForm">
                            <span class="glyphicon glyphicon-floppy-disk"></span> <span class="hidden-xs">{{ __('Save') }}</span>
                        </button>
                        <a href="" class="btn btn-info btn-tooltip" target="_blank" title="{{ __('View the page') }}">
                            <span class="glyphicon glyphicon-eye-open"></span> <span class="hidden-xs hidden-sm">{{ __('View page') }}</span>
                        </a>
                        @if(!$page->isEnabled)
                        <a href="{{ route('admin.pages.enable', ['id' => $page->id, 'enable' => 1]) }}" title="{{ __('Enable') }}" class="btn btn-success btn-tooltip">
                            <span class="glyphicon glyphicon-ok"></span> <span class="hidden-xs hidden-sm">{{ __('Enable') }}</span>
                        </a>
                        @else
                        <a href="{{ route('admin.pages.enable', ['id' => $page->id, 'enable' => 0]) }}" title="{{ __('Disable') }}" class="btn btn-warning btn-tooltip">
                            <span class="glyphicon glyphicon-remove"></span> <span class="hidden-xs hidden-sm">{{ __('Disable') }}</span>
                        </a>
                        @endif

                        <a href="{{ route('admin.pages.delete', ['id' => $page->id]) }}"
                           title="{{ __('Delete') }}"
                           data-url="{{ route('admin.pages.delete', ['id' => $page->id, 'confirm' => true]) }}"
                           class="btn btn-danger btn-tooltip delete">
                            <span class="glyphicon glyphicon-trash"></span> <span class="hidden-xs hidden-sm">{{ __('Delete') }}</span>
                        </a>
                    </div>

                </h2>
            </div>

            <div class="row">
                <div class="col-md-12">

                    <ul id="myTab" class="nav nav-tabs page-tabs">
                        <li @if($tab == 'content') class="active" @endif><a href="#content" data-toggle="tab">{{ __('Content') }}</a></li>
                        @if($enabledLang)
                        <li @if($tab == 'langs') class="active" @endif><a href="#langs" data-toggle="tab">{{ __('Language') }}</a></li>
                        @endif
                        <li @if($tab == 'parameters') class="active" @endif><a href="#parameters" data-toggle="tab">{{ __('Parameters') }}</a></li>
                        <li @if($tab == 'modulearea') class="active" @endif><a href="#modulearea" data-toggle="tab">{{ __('Module area') }}</a></li>
                        <li @if($tab == 'security') class="active" @endif><a href="#security" data-toggle="tab">{{ __('Security') }}</a></li>
                    </ul>
                </div>
            </div>
            <div class="row">

                <div class="col-md-12">

                    <div class="tab-content">
                        <div class="tab-pane @if($tab == 'content') active @endif page-tab" id="content">

                            <div id="component-container">

                            </div>
                            <p class="text-center">
                                <button id="add-page-module" class="btn btn-lg btn-primary text-center" style="margin-top : 20px;"><span class="glyphicon glyphicon-plus"></span> {{ __('Add component') }}</button>
                            </p>
                        </div>

                        @if($enabledLang)
                        <div class="tab-pane @if($tab == 'langs') active @endif page-tab" id="langs">

                            @include('pages.edit-langs')

                        </div>
                        @endif

                        <div class="tab-pane @if($tab == 'parameters') active @endif page-tab" id="parameters">

                            @include('pages.edit-parameters')

                        </div>

                        <div class="tab-pane @if($tab == 'modulearea') active @endif page-tab" id="modulearea">

                            @include('pages.edit-modulearea')

                        </div>
                        <div class="tab-pane @if($tab == 'security') active @endif page-tab" id="security">

                            @include('pages.edit-security')

                        </div>
                    </div>
                </div>
            </div>
        {{ Form::close() }}
    </div>
@endsection
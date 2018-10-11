@extends('layouts.app')

{{--
@push('scripts')
    <script src="{{ asset('js/jquery.nestable.js') }}" language="JavaScript"></script>
    <script src="{{ asset('js/custom.nestable.js') }}" language="JavaScript"></script>
    <script src="{{ asset('js/omega/admin/apparance/menu/add.js') }}" language="JavaScript"></script>
@endpush
--}}

@section('content')
{{ Form::open(['url' => route('menu.create'), 'method' => 'POST']) }}
    <br />
    <br />

    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ __('Add a menu') }}
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        {{ Form::label('name', __('Name', ['class' => 'control-label'])) }}
                        {{ Form::text('name', null, ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    {{ Form::hidden('isMain', 0) }}
                                    {{ Form::checkbox('isMain', 1, false) }}
                                    {{ __('Is Main menu') }}
                                </label>
                            </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('membergroup', __('Membergroup', ['class' => 'control-label'])) }}
                        {{ Form::select('membergroup', $membergroups, null, ['class' => 'form-control']) }}
                    </div>
                    @if($langEnabled)
                    <div class="form-group">
                        {{ Form::label('lang', __('Languages', ['class' => 'control-label'])) }}
                        {{ Form::select('lang', $langs, null, ['class' => 'form-control']) }}
                    </div>
                    @else
                        {{ Form::hidden('lang', null) }}
                    @endif

                    <p>
                        <input type="submit" class="btn btn-info" name="addMenu" value="{{ __('Add new') }}" />
                        <a href="{{ route('menu.index') }}" class="btn btn-default">{{ __('Cancel') }}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
{{ Form::close() }}
@endsection
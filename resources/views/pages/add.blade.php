@extends('layouts.app')

@push('scripts')
    <script src="{{ asset('js/omega/admin/pages/add.js') }}" defer></script>
@endpush


@section('content')
    <br />
    <br />

    {{ Form::open(['route' => ['admin.pages.create'], 'method' => 'POST']) }}
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ __('Add a page') }}
                    </div>
                    <div class="panel-body">
                        {{ Form::label('name', __('Title')) }}
                        {{ Form::text('name', null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => __('Title')]) }}
                        @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif

                        @if($enableLang)
                            <br>
                            {{ Form::label('lang', __('Language')) }}
                            {{ Form::select('lang', $langs, $selectedLang, ['class' => 'form-control', 'id' => 'lang']) }}
                            @if ($errors->has('lang'))
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('lang') }}</strong>
                            </span>
                            @endif
                        @endif

                        <br>
                        {{ Form::label('parent', __('Parent')) }}
                        {{ Form::select('parent', $pages, null, ['class' => 'form-control', 'id' => 'parent']) }}
                        @if ($errors->has('parent'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('parent') }}</strong>
                            </span>
                        @endif


                        <br>
                        <p>
                            <button type="submit" name="addPage" class="btn btn-primary">{{ __('Create') }}</button>
                            <a href="{{ route('admin.pages') }}" class="btn btn-default">{{ __('Cancel') }}</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    {{ Form::close() }}
@endsection
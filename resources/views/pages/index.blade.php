@extends('layouts.app')


@push('scripts')
    <script src="{{ asset('js/omega/admin/pages/index.js') }}" defer></script>
@endpush

@section('content')
    <h1 class="page-header">{{ __('Pages') }}</h1>

    <p>
        @php $args = $enabledLang ? ['lang' => $currentLang] : []; @endphp
        <a href="{{ route('admin.pages.add', $args) }}" class="btn btn-primary btn-tooltip" title="{{ __('Add new') }}">
            <span class="glyphicon glyphicon-plus-sign"></span> {{ __('Add new') }}
        </a>
        <a href="#" id="sortPages" class="btn btn-default btn-tooltip" title="{{ __('Sort') }}"><span class="glyphicon glyphicon-sort"></span> {{ __('Sort') }}</a>

        @if($enabledLang)
            {{ Form::open(['route' => ['admin.pages.chooselang'], 'method' => 'POST', 'class' => 'form-inline']) }}
            <div class="form-group">
                {{ Form::select('lang', $langs, $currentLang, ['id' => 'choose-lang', 'class' => 'form-control']) }}
            </div>
            <button type="submit" class="btn btn-default" name="formChooseLang">Choose language</button>
            {{ Form::close() }}
        @endif
    </p>


    <div id="tableContainer">

    </div>

@endsection
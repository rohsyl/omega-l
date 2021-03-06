@extends('layouts.app')


@push('scripts')
    <script src="{{ asset('js/omega/admin/pages/index.js') }}" defer></script>
@endpush

@section('content')
    <h1 class="page-header">{{ __('Pages') }}</h1>

    <div class="row">
        <div class="col-sm-6">
            @if($enabledLang)
                {{ Form::open(['route' => ['admin.pages.chooselang'], 'method' => 'POST', 'class' => 'form-inline main-form']) }}
                <div class="form-group" >
                    {{ Form::label('lang', __('Filter by language') . ' :') }}
                    {{ Form::select('lang', $langs, $currentLang, ['id' => 'choose-lang', 'class' => 'form-control', 'onchange' => 'this.form.submit()']) }}
                </div>
                {{ Form::close() }}
            @endif
        </div>
        <div class="col-sm-6 pull">
            <p class="text-right">
                @php $args = $enabledLang ? ['lang' => $currentLang] : []; @endphp
                <a href="{{ route('admin.pages.trash') }}" class="btn btn-default btn-tooltip" title="{{ __('Manage and restore deleted pages') }}">
                    <i class="fa fa-trash"></i> {{ __('Manage Trash') }}
                </a>
                <a href="#" id="sortPages" class="btn btn-default btn-tooltip" title="{{ __('Sort pages') }}">
                    <span class="glyphicon glyphicon-sort"></span> {{ __('Sort') }}
                </a>
                <a href="{{ route('admin.pages.add', $args) }}" class="btn btn-primary btn-tooltip" title="{{ __('Add a new page to your website') }}">
                    <span class="glyphicon glyphicon-plus-sign"></span> {{ __('Add new') }}
                </a>
            </p>
        </div>

    </div>

    <br />
    <div id="tableContainer" data-lang-current="{{ $currentLang }}" data-lang-enabled="{{ $enabledLang }}">
        <script>
            document.write(omega.ajax.getSpinner());
        </script>
    </div>

@endsection
@extends('layouts.app')

@push('scripts')
@endpush

@section('content')

    <div id="page-edit-app">

    </div>
    <script id="page_id" type="application/json">
        {{ $id }}
    </script>
    <script src="{{ mix('js/app/page-edit-app.js') }}"></script>
@endsection

@push('scripts')
@endpush
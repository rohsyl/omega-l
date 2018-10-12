@extends('layouts.app')


@push('scripts')
    @include('media.script_library')
@endpush

@section('content')
    @include('media.html_library')
@endsection
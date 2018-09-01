@extends('layouts.app')

@section('content')
    <h2 class="page-header">
        <span class="glyphicon glyphicon-cloud-upload"></span> {{ __('File uploader') }}
    </h2>

    @include('media.uploader')
@endsection
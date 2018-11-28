@extends('layouts.app')

@section('content')
    <br />
    <br />
    <div align="center">
        <p>{{ __('Do you really want to delete this page') }}?</p>
        <a class="btn btn-primary" href="{{ route('admin.pages.delete', ['id' => $id, 'confirm' => true]) }}">{{ __('Yes') }}</a>
        <a class="btn btn-default" href="{{ route('admin.pages') }}">{{ __('No') }}</a>
    </div>
@endsection
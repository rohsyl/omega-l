@extends('layouts.app')

@section('content')
    <div align="center">
        <p>{{ __('Do you really want to delete this user') }}?</p>
        <a class="btn btn-primary" href="{{ route('user.delete', ['id' => $id, 'confirm' => true]) }}">{{ __('Yes') }}</a>
        <a class="btn btn-default" href="{{ route('user.index') }}">{{ __('No') }}</a>
    </div>
@endsection
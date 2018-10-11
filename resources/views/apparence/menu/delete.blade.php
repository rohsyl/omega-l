@extends('layouts.app')

@section('content')
    <div align="center">
        <p>{{ __('Do you really want to delete this menu') }}?</p>
        <a class="btn btn-primary" href="{{ route('menu.delete', ['id' => $id, 'confirm' => true]) }}">{{ __('Yes') }}</a>
        <a class="btn btn-default" href="{{ route('menu.index') }}">{{ __('No') }}</a>
    </div>
@endsection
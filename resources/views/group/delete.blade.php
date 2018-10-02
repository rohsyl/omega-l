@extends('layouts.app')

@section('content')
    <div align="center">
        <p>{{ __('Do you really want to delete this group') }}?</p>
        <a class="btn btn-primary" href="{{ route('group.delete', ['id' => $id, 'confirm' => true]) }}">{{ __('Yes') }}</a>
        <a class="btn btn-default" href="{{ route('group.index') }}">{{ __('No') }}</a>
    </div>
@endsection
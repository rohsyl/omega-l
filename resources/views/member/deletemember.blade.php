@extends('layouts.app')

@section('content')
    <div align="center">
        <p>{{ __('Do you really want to delete this member') }}?</p>
        <a class="btn btn-primary" href="{{ route('member.deletemember', ['id' => $id, 'confirm' => true]) }}">{{ __('Yes') }}</a>
        <a class="btn btn-default" href="{{ route('member.index) }}">{{ __('No') }}</a>
    </div>
@endsection
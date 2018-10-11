@extends('layouts.app')

@section('content')
    <h1 class="page-header">{{ __('Members') }}</h1>
    <div class="panel panel-default">
        <div class="panel-heading">
            {{ __('Membergroups') }}
            <div class="pull-right">
                <a href="{{ route('member.addmembergroup') }}" class="btn btn-xs btn-primary">
                    <span class="glyphicon glyphicon-plus-sign"></span> {{ __('Add new') }}
                </a>
            </div>
        </div>
        <table class="table table-hover table-page-list">
            @foreach($membergroups as $mgroup)
            <tr>
                <td><a  href="{{ route('member.editmembergroup', ['id' => $mgroup->id]) }}">{{ $mgroup->name }}</a></td>
                <td>
                        <span class="action-img-page-list">
                            <a  href="{{ route('member.editmembergroup', ['id' => $mgroup->id]) }}"
                                title="{{ __('Edit') }}">{{ __('Edit') }}</a>
                            |
                            <a  href="{{ route('member.deletemembergroup', ['id' => $mgroup->id]) }}"
                                title="{{ __('Delete') }}"
                                data-url="{{ route('member.deletemembergroup', ['id' => $mgroup->id, 'confirm' => 1]) }}"
                                class="delete text-danger">{{ __('Delete') }}</a>
                        </span>
                </td>
            </tr>
            @endforeach
        </table>
    </div>


    <div class="panel panel-default">
        <div class="panel-heading">
            {{ __('Members') }}
            <div class="pull-right">
                <a href="{{ route('member.addmember') }}" class="btn btn-xs btn-primary">
                    <span class="glyphicon glyphicon-plus-sign"></span> {{ __('Add new') }}
                </a>
            </div>
        </div>
        <table class="table table-hover table-page-list">
            @foreach($members as $member)
            <tr>
                <td><a  href="{{ route('member.editmember', ['id' => $member->id]) }}">{{ $member->username }}</a></td>
                <td>
                    <span class="text-warning">{{ $member->isValid == 0 ? 'Need mail confirmation' : '' }}</span>
                    <span class="text-warning">{{ $member->lostPasswordHash != null ? 'Need password changment' : '' }}</span>
                </td>
                <td>
                            <span class="action-img-page-list">
                                <a  href="{{ route('member.editmember', ['id' => $member->id]) }}"
                                    title="{{ __('Edit') }}">{{ __('Edit') }}</a>
                                |
                                <a  href="{{ route('member.deletemember', ['id' => $member->id]) }}"
                                    title="{{ __('Delete') }}"
                                    data-url="{{ route('member.deletemember', ['id' => $member->id, 'confirm' => 1])}}"
                                    class="delete text-danger">{{ __('Delete') }}</a>
                            </span>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
@endsection
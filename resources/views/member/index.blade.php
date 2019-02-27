@extends('layouts.app')

@section('content')
    <h1 class="page-header">{{ __('Members') }}</h1>

    @if(has_right('membergroup_read'))
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ __('Membergroups') }}
                @if(has_right('membergroup_add'))
                    <div class="pull-right">
                        <a href="{{ route('member.addmembergroup') }}" class="btn btn-xs btn-primary">
                            <span class="glyphicon glyphicon-plus-sign"></span> {{ __('Add new') }}
                        </a>
                    </div>
                @endif
            </div>
            <table class="table table-hover table-page-list">
                @foreach($membergroups as $mgroup)
                    <tr>
                        <td>

                            @if(has_right('membergroup_update'))
                                <a  href="{{ route('member.editmembergroup', ['id' => $mgroup->id]) }}">{{ $mgroup->name }}</a>
                            @else
                                {{ $mgroup->name }}
                            @endif

                        </td>
                        <td>
                        <span class="action-img-page-list">
                            @if(has_right('membergroup_update'))
                                <a  href="{{ route('member.editmembergroup', ['id' => $mgroup->id]) }}"
                                    title="{{ __('Edit') }}">{{ __('Edit') }}</a>
                            @endif
                            &nbsp;
                            @if(has_right('membergroup_delete'))
                                <a  href="{{ route('member.deletemembergroup', ['id' => $mgroup->id]) }}"
                                    title="{{ __('Delete') }}"
                                    data-url="{{ route('member.deletemembergroup', ['id' => $mgroup->id, 'confirm' => 1]) }}"
                                    class="delete text-danger">{{ __('Delete') }}</a>
                            @endif
                        </span>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    @endif


    @if(has_right('member_read'))
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ __('Members') }}
                @if(has_right('member_add'))
                    <div class="pull-right">
                        <a href="{{ route('member.addmember') }}" class="btn btn-xs btn-primary">
                            <span class="glyphicon glyphicon-plus-sign"></span> {{ __('Add new') }}
                        </a>
                    </div>
                @endif
            </div>
            <table class="table table-hover table-page-list">
                @foreach($members as $member)
                    <tr>
                        <td>
                            @if(has_right('member_update'))
                                <a  href="{{ route('member.editmember', ['id' => $member->id]) }}">{{ $member->username }}</a>
                            @else
                                {{ $member->username }}
                            @endif
                        </td>
                        <td>
                            <span class="text-warning">{{ $member->isValid == 0 ? 'Need mail confirmation' : '' }}</span>
                            <span class="text-warning">{{ $member->lostPasswordHash != null ? 'Need password changment' : '' }}</span>
                        </td>
                        <td>
                            <span class="action-img-page-list">
                                @if(has_right('member_update'))
                                    <a  href="{{ route('member.editmember', ['id' => $member->id]) }}"
                                        title="{{ __('Edit') }}">{{ __('Edit') }}</a>
                                @endif
                                &nbsp;
                                @if(has_right('member_delete'))
                                    <a  href="{{ route('member.deletemember', ['id' => $member->id]) }}"
                                        title="{{ __('Delete') }}"
                                        data-url="{{ route('member.deletemember', ['id' => $member->id, 'confirm' => 1])}}"
                                        class="delete text-danger">{{ __('Delete') }}</a>
                                @endif
                            </span>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    @endif

@endsection
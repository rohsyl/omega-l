@extends('layouts.app')

@section('content')
    <h1 class="page-header">{{ __('Groups') }}</h1>

    <table class="table table-hover">
        <tr>
            <th>{{ __('Name') }}</th>
            <th>{{ __('Is system') }}</th>
            <th>
                <span style="float:right"><a href="{{ route('group.add') }}" class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-plus-sign"></span>&nbsp;{{ __('Add new') }}</a>
                </span>
            </th>
        </tr>

        @foreach($groups as $group)
            <tr>
                <td><a href="{{ route('group.edit', ['id' => $group->id]) }}">{{ $group->name }}</a></td>
                <td>@if($group->isSystem)<i class="fa fa-check"></i>@else<i class="fa fa-times"></i>@endif</td>
                <td>
				<span class="action-img-page-list">
					<a href="{{ route('group.edit', ['id' => $group->id]) }}" title="{{ __('Edit') }}">{{ __('Edit') }}</a>
                    @if(!$group->isSystem)
                        |
                        @if($group->isEnabled)
                            <a href="{{ route('group.enable', ['id' => $group->id, 'enable' => 0]) }}" title="{{ __('Disable') }}">{{ __('Disable') }}</a>
                        @else
                            <a href="{{ route('group.enable', ['id' => $group->id, 'enable' => 1]) }}" title="{{ __('Enable') }}">{{ __('Enable') }}</a>
                        @endif
                        | <a href="{{ route('group.delete', ['id' => $group->id]) }}" title="{{ __('Delete') }}"
                             data-url="{{ route('group.delete', ['id' => $group->id, 'confirm' => true]) }}" class="delete text-danger">{{ __('Delete') }}</a>
                    @endif
				</span>
                </td>
            </tr>
        @endforeach
    </table>

@endsection
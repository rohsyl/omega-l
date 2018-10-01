@extends('layouts.app')

@section('content')
    <h1 class="page-header">{{ __('Users') }}</h1>

    <table class="table table-hover">
        <tr>
            <th>{{ __('Login') }}</th>
            <th>{{ __('Name') }}</th>
            <th>{{ __('E-mail') }}</th>
            <th class="date">{{ __('Created') }}</th>
            <th class="date">{{ __('Updated') }}</th>
            <th>
                <span style="float:right"><a href="{{ route('user.add') }}" class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-plus-sign"></span>&nbsp;{{ __('Add new') }}</a>
                </span>
            </th>
        </tr>

        @foreach($users as $user)
            <tr>
                <td><a href="{{ route('user.edit', ['id' => $user->id]) }}">{{ $user->username }}</a></td>
                <td>{{ $user->fullname }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at }}</td>
                <td>{{ $user->updated_at }}</td>
                <td>
				<span class="action-img-page-list">
					<a href="{{ route('profile', $user->id) }}" title="{{ __('Profile') }}">{{ __('Profile') }}</a>
					| <a href="{{ route('user.edit', ['id' => $user->id]) }}" title="{{ __('Edit') }}">{{ __('Edit') }}</a>
					|
                    @if($user->isEnabled)

                    <a href="{{ route('user.enable', ['id' => $user->id, 'enable' => 0]) }}" title="{{ __('Disable') }}">{{ __('Disable') }}</a>

                    @else

                    <a href="{{ route('user.enable', ['id' => $user->id, 'enable' => 1]) }}" title="{{ __('Enable') }}">{{ __('Enable') }}</a>

                    @endif
                    | <a href="{{ route('user.delete', ['id' => $user->id]) }}" title="{{ __('Delete') }}"
                         data-url="{{ route('user.delete', ['id' => $user->id, 'confirm' => true]) }}" class="delete text-danger">{{ __('Delete') }}</a>
				</span>
                </td>
            </tr>
        @endforeach
    </table>

@endsection
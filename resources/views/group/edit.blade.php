@extends('layouts.app')

@section('content')
{{ Form::open(['url' => route('group.edit', ['id' => $group->id]), 'class' => 'form-horizontale']) }}
    <div class="page-header">
        <h1>{{ __('Group edit') }}
            @if(!$group->isEnabled)
                <small>{{ __('This group is disabled') }}</small>
            @endif
            @if(!$group->isSystem)
                <small>{{ __('This is a system group') }}</small>
            @endif

            <div class="toolbar">
                <button type="submit" class="btn btn-primary form-multiselect">{{ __('Update') }}</button>

                @if(!$group->isSystem)
                    @if($group->isEnabled)
                        <a href="{{ route('group.enable', ['id' => $group->id, 'enable' => 0]) }}" class="btn btn-warning">{{ __('Disable') }}</a>
                    @else
                        <a href="{{ route('group.enable', ['id' => $group->id, 'enable' => 1]) }}" class="btn btn-success">{{ __('Enable') }}</a>
                    @endif
                    <a href="{{ route('group.delete', ['id' => $group->id]) }}" class="btn btn-danger">{{ __('Delete') }}</a>
                @endif
                <a href="{{ route('group.index') }}" class="btn btn-default">{{ __('Cancel') }}</a>
            </div>
        </h1>
    </div>
    <div class="row">
        <div class="col-md-8">

            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ __('Rigths') }}
                </div>
                <div class="panel-body">
                    <div style="height : 300px; overflow-y : scroll">
                        <table class="table">
                            <tr>
                                <th></th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Description') }}</th>
                            </tr>
                            @foreach($rights as $r)
                                <tr>
                                    <td>
                                        {{ Form::checkbox('rights[]', $r->id, $group->rights->contains($r->id), [$group->isSystem ? 'disabled' : '']) }}
                                    </td>
                                    <td>{{ $r->getNiceName() }}</td>
                                    <td>{{ $r->description }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>


            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ __('Users') }}
                </div>
                <div class="panel-body">
                    <div style="max-height : 300px; overflow-y : scroll">
                        <table class="table">
                            <tr>
                                <th></th>
                                <th>{{ __('Username') }}</th>
                                <th>{{ __('Fullname') }}</th>
                            </tr>
                            @foreach($users as $user)
                                <tr>
                                    <td>
                                        {{ Form::checkbox('users[]', $user->id, $group->users->contains($user->id)) }}
                                    </td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->fullname }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ __('Informations') }}
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        {{ Form::label('name', __('Name'), ['class' => 'control-label']) }}
                        {{ Form::text('name', $group->name, ['class' => 'form-control', 'placeholder' => __('Name'), $group->isSystem ? 'disabled' : '']) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('description', __('Description'), ['class' => 'control-label']) }}
                        {{ Form::textarea('description', $group->description, ['class' => 'form-control', 'placeholder' => __('Description'),  $group->isSystem ? 'disabled' : '']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
{{ Form::close() }}
@endsection
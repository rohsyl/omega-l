@extends('layouts.app')

@section('content')

{{ Form::open(['url' => route('group.create'), 'class' => 'form-horizontal main-form']) }}
    <div class="page-header">
        <h1>{{ __('Add group') }}
            <div class="toolbar">
                <button type="submit" class="btn btn-primary form-multiselect" name="formAddGroup" >{{ __('Create') }}</button>
                <a href="{{ route('group.index') }}" class="btn btn-default">{{ __('Cancel') }}</a>
            </div>
        </h1>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ __('Rights') }}
                </div>
                <div class="panel-body">
                    <div style="max-height : 300px; overflow-y : scroll">
                        <table class="table">
                            <tr>
                                <th></th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Description') }}</th>
                            </tr>
                            @foreach($rights as $right)
                            <tr>
                                <td>
                                    {{ Form::checkbox('rights[]', $right->id) }}
                                </td>
                                <td>{{ $right->getNiceName() }}</td>
                                <td>{{ $right->description }}</td>
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
                                    {{ Form::checkbox('users[]', $user->id) }}
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
                        {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Name')]) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('description', __('Description'), ['class' => 'control-label']) }}
                        {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __('Description')]) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
{{ Form::close() }}
@endsection
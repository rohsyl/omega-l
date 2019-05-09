@extends('layouts.app')

@section('content')
    {{ Form::open(['url' => route('member.updatemembergroup', ['id' => $membergroup->id, 'class' => 'form-horizontal main-form'])]) }}
        <div class="page-header">
            <h1>{{ __('Edit member group') }}
                <div class="toolbar">
                    <input type="submit" name="editmembergroup" class="btn btn-primary" value="{{ __('Save') }}" />
                    @if(has_right('membergroup_delete'))
                    <a class="btn btn-danger"  href="{{ route('member.deletemembergroup', ['id' => $membergroup->id]) }}" >{{ __('Delete') }}</a>
                    @endif
                    <a href="{{ route('member.index') }}" class="btn btn-default">{{ __('Cancel') }}</a>
                </div>
            </h1>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ __('Informations') }}
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            {{ Form::label('name', __('Name'), ['class' => 'col-md-4 control-label']) }}
                            <div class="col-md-4">
                                {{ Form::text('name', $membergroup->name, ['class' => 'form-control', 'placeholder' => __('Name')]) }}
                                @if ($errors->has('name'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @else
                                    <div class="help-block">
                                        {{ __('The name of the group') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ __('Grouping') }}
                    </div>
                    <div class="panel-body">
                        <table class="table">
                            @if(sizeof($members) == 0)
                                <tr>
                                    <td class="text-center">{{ __('No members') }}</td>
                                </tr>
                            @endif
                            @foreach($members as $member)
                            <tr>
                                <td width="40">
                                    {{ Form::checkbox('members[]', $member->id, $membergroup->members->contains($member->id)) }}
                                </td>
                                <td>{{ $member->username }}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    {{ Form::close() }}
@endsection
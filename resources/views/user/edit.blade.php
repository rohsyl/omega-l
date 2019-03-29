@extends('layouts.app')

@section('content')
{{ Form::open(['url' => route('user.update', ['id' => $user->id]), 'method' => 'post', 'class' => 'form-horizontal']) }}
    <div class="page-header">
        <h1>{{ __('Edit user') }}
            @if(!$user->isEnabled)
                <small>{{ __('This user is disabled') }}</small>
            @endif

            <div class="toolbar">
                <button type="submit" name="updateUser" class="btn btn-primary form-multiselect">{{ __('Update') }}</button>
                <a href="{{ route('user.edit.passwd', ['id' => $user->id]) }}" class="btn btn-warning">{{ __('Change password') }}</a>

                {{-- TODO : has right --}}
                @if($user->isEnabled)
                    <a href="{{ route('user.enable', ['id' => $user->id, 'enable' => 0]) }}" class="btn btn-warning">{{ __('Disable') }}</a>
                @else
                    <a href="{{ route('user.enable', ['id' => $user->id, 'enable' => 1]) }}" class="btn btn-success">{{ __('Enable') }}</a>
                @endif
                <a href="{{ route('user.delete', ['id' => $user->id]) }}" class="btn btn-danger">{{ __('Delete') }}</a>


                <a href="{{ route('user.index') }}" class="btn btn-default">{{ __('Cancel') }}</a>
            </div>
        </h1>
    </div>
    <div class="row">
        <div class="col-md-9">

            @if(has_right ('user_update_data') || has_right('user_update_himself'))
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ __('Informations') }}
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        {{ Form::label('username', __('Username'), ['class' => 'col-sm-3 control-label']) }}
                        <div class="col-sm-5">
                            {{ Form::text('username', $user->username, ['class' => 'form-control', 'disabled']) }}
                            @if ($errors->has('username'))
                                <span class="text-danger" role="alert">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                            @else
                                <div class="help-block">
                                    {{ __('Username can\'t be changed.') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('email', __('E-mail'), ['class' => 'col-sm-3 control-label']) }}
                        <div class="col-sm-5">
                            {{ Form::text('email', $user->email, ['class' => 'form-control']) }}
                            @if ($errors->has('email'))
                                <span class="text-danger" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('fullname', __('Fullname'), ['class' => 'col-sm-3 control-label']) }}
                        <div class="col-sm-5">
                            {{ Form::text('fullname', $user->fullname, ['class' => 'form-control']) }}
                            @if ($errors->has('fullname'))
                                <span class="text-danger" role="alert">
                                <strong>{{ $errors->first('fullname') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif



            @if(has_right('user_update_group'))
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ __('Groups') }}
                </div>
                <div class="panel-body">
                    <div style="height : 200px; overflow-y : scroll">
                        <table class="table">
                            <tr>
                                <th></th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Description') }}</th>
                            </tr>

                            @foreach($groups as $g)
                                <tr>
                                    <td>
                                        {{ Form::checkbox('groups[]', $g->id, $user->groups->contains($g->id)) }}
                                    </td>
                                    <td>{{ $g->getNiceName() }}</td>
                                    <td>{{ $g->description }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            @endif




            @if(has_right('user_update_rights'))
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ __('Rights') }}
                    </div>
                    <div class="panel-body">
                        <div style="height : 200px; overflow-y : scroll">
                            <table class="table">
                                <tr>
                                    <th></th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Description') }}</th>
                                </tr>

                                @foreach($rights as $r)
                                    <tr>
                                        <td>
                                            {{ Form::checkbox('rights[]', $r->id, $user->rights->contains($r->id)) }}
                                        </td>
                                        <td>{{ $r->getNiceName() }}</td>
                                        <td>{{ $r->description }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            @endif


        </div>


        <div class="col-md-3">

            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ __('Avatar') }}
                </div>
                <div class="panel-body">
                    <div class="userAvatarContainer">
                        @if(isset($user->avatar))
                            <div class="userAvatarImage" style="background-image: url('{{ $user->getAvatarMedia() }}')"></div>
                        @elseif(!empty($user->fullname))
                        <span class="userAvatarText">
                                {{ strtoupper(substr($user->fullname, 0, 1)) }}
                            </span>
                        @else
                        <span class="userAvatarIcon"><i class="fa fa-user fa-4x"></i></span>
                        @endif
                    </div>
                    <p class="text-center" style="margin-top : 10px;">
                        <button type="button" id="updateAvatar" class="btn btn-primary">{{ __('Change') }}</button>
                        <button {{ !isset($user->avatar) ? 'style="display: none;"' : '' }} type="button" id="deleteAvatar" class="btn btn-danger">{{ __('Delete') }}</button>

                    </p>
                </div>
            </div>
        </div>
    </div>
{{ Form::close() }}

@endsection

@push('scripts')
    <script>
        $(function(){
            var userInitial = '{{ strtoupper(substr($user->userFirstName, 0, 1) . substr($user->userName, 0, 1)) }}';
            var userInitialSet = {{ !empty($user->userFirstName) && !empty($user->userName) ? 'true' : 'false' }};
            var userId = {{ $user->id }};
            var $btnUpdateAvatar = $('#updateAvatar');
            var $btnDeleteAvatar = $('#deleteAvatar');
            var $userAvatarContainer = $('.userAvatarContainer');

            $btnUpdateAvatar.rsMediaChooser({
                multiple: false,
                allowedMedia: [
                    'picture'
                ],
                doneFunction: function (data) {
                    id = data.id;
                    var url = route('user.saveAvatar', {userId: userId, mediaId: id});
                    omega.ajax.query(url, {}, omega.ajax.GET, function(json){
                        var html = '<div class="userAvatarImage" style="background-image: url(\''+json.url+'\')"></div>';
                        $userAvatarContainer.html(html);
                        $btnDeleteAvatar.show();
                        omega.notice.success('Success', 'Avatar updated');
                    }, undefined, {dataType: 'json'});
                }
            });

            $btnDeleteAvatar.click(function(){
                var url = route('user.deleteAvatar', {userId: userId});
                omega.ajax.query(url, {}, omega.ajax.GET, function(json){
                    $btnDeleteAvatar.hide();
                    var html;
                    if(userInitialSet){
                        html = '<span class="userAvatarText">'+userInitial+'</span>';
                    }
                    else{
                        html = '<span class="userAvatarIcon"><i class="fa fa-user fa-4x"></i></span>';
                    }
                    $userAvatarContainer.html(html);
                    omega.notice.success('Success', 'Avatar updated');
                }, undefined, {dataType: 'json'});
            });
        });
    </script>
@endpush
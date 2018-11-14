@extends('layouts.app')

@section('content')
   <h1 class="page-header">{{ __('Profile') }}</h1><br />
   <div class="row">
       <div class="col-md-4 col-sm-12">
           <div class="well well-sm">
               <div class="row">
                   <div class="col-sm-7">
                       <div class="userAvatarContainer">
                           {!! OmegaUtils::GetUserAvatar($user) !!}
                       </div>
                   </div>
                   <div class="col-sm-5">
                       <h4>{{ $user->fullname }}</h4>
                       <p>
                           <br />
                           <i class="glyphicon glyphicon-log-in"></i> {{ $user->username }}
                           <br />
                           <i class="glyphicon glyphicon-envelope"></i> {{ $user->email }}
                       </p>
                       <br /><br />
                       <p class="text-right">
                           @if($displayUpdateButton)
                           <a href="{{ route('user.edit', ['id' => $user->id]) }}" class="btn btn-default" style="margin-right: 15px;">{{ __('Edit the profile') }}</a>
                           @endif
                       </p>
                   </div>
               </div>
           </div>
       </div>
   </div>
@endsection
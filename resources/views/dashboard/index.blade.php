@extends('layouts.app')

@section('content')

    <h1 class="page-header">{{ __('Dashboard') }}</h1>
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-file fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{ $stats['page'] }}</div>
                            <div>{{ __('Pages') }}</div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('admin.pages.add') }}">
                    <div class="panel-footer">
                        <span class="pull-left">{{ __('Add page') }}</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-users fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{ $stats['user'] }}</div>
                            <div>{{ __('Users') }}</div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('user.add') }}">
                    <div class="panel-footer">
                        <span class="pull-left">{{ __('Add user') }}</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row" style="padding-top : 7px;">
                        <div class="col-xs-3">
                            <i class="fa fa-cog fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <p style="font-size : 10px; padding-right : 5px; margin-top : 22px;" class="text-right">
                                {{ __('CMS version') }} : <span id="current_version"></span>
                            </p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('admin.settings') }}">
                    <div class="panel-footer">
                        <span class="pull-left">{{ __('Settings') }}</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-picture-o fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <a href="{{ route('media.library') }}" style="color : #fff;" class="link-home">
                                <div class="huge"><i class="fa fa-upload"></i></div>
                                <div>{{ __('Upload files') }}</div>
                            </a>
                        </div>
                    </div>
                </div>
                <a href="{{ route('media.library') }}">
                    <div class="panel-footer">
                        <span class="pull-left">{{ __('Media Library') }}</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-file"></i> {{ __('Last updated pages') }}</div>
                <div class="panel-body">
                    <table class="table table-condensed table-hover">
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <th><small>{{ __('Updated at') }}</small></th>
                            <th></th>
                        </tr>
                        @foreach($pages as $page)
                        <tr>
                            <td>
                                {{ $page->name }}

                            </td>
                            <td>
                                <em><small> {{ $page->updated_at }}</small></em>
                            </td>
                            <td class="text-right">
                                <a href="{{ \Omega\Utils\Entity\Page::GetUrl($page->id) }}" target="_blank">
                                    <i class="fa fa-search"></i>
                                </a>
                                @if(has_right('page_update'))&nbsp;
                                    <a href="{{ route('admin.pages.edit', ['id' => $page->id]) }}"><i class="fa fa-edit"></i></a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-users"></i> {{ __('Users') }}</div>
                <div class="panel-body">
                    <table class="table table-condensed table-hover">
                        <tr>
                            <th>{{ __('Username') }}</th>
                            <th></th>
                        </tr>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->displayName() }}</td>
                                <td class="text-right">
                                    <a href="{{ route('profile', ['id' => $user->id]) }}"><i class="fa fa-search"></i></a>&nbsp;
                                    <a href="{{ route('user.edit', ['id' => $user->id]) }}"><i class="fa fa-edit"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-hand-spock-o"></i> {{ __('Theme') }}</div>
                <div class="panel-body">
                    {{ __('Current theme') }} : <a href="{{ route('theme.detail', ['theme' => $stats['theme']]) }}">{{ $stats['theme'] }}</a>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-cog"></i> {{ __('Update') }}</div>
                <div class="panel-body">
                    <a href="{{ route('admin.update.check') }}">{{ __('Check for update') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script language="JavaScript">
        $(function() {
           var $current_version = $('#current_version');

           let url = route('laraupdater.current');

           omega.ajax.query(url, {}, omega.ajax.GET, function(data) {
              $current_version.html(data);
           });
        });
    </script>
@endpush
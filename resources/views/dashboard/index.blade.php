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
                                CMS version : <br />
                                Database version :
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
                            <a href="{{ route('media.uploader') }}" style="color : #fff;" class="link-home">
                                <div class="huge"><i class="fa fa-upload"></i></div>
                                <div>Upload files</div>
                            </a>
                        </div>
                    </div>
                </div>
                <a href="{{ route('media.library') }}">
                    <div class="panel-footer">
                        <span class="pull-left">{{ __('Media library') }}</span>
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
                <div class="panel-heading"><i class="fa fa-file"></i> {{ __('Pages') }}</div>
                <div class="panel-body">
                    <table class="table table-condensed table-hover">
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <th></th>
                        </tr>

                        <tr>
                            <td></td>
                            <td class="text-right">
                                <a href=""><i class="fa fa-edit"></i></a>
                            </td>
                        </tr>
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

                        <tr>
                            <td></td>
                            <td class="text-right">
                                <a href=""><i class="fa fa-search"></i></a>&nbsp;
                                <a href=""><i class="fa fa-edit"></i></a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-hand-spock-o"></i> {{ __('Template') }}</div>
                <div class="panel-body">
                    Current theme : <a href="">{{ $stats['theme'] }}</a>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-cog"></i> {{ __('Update') }}</div>
                <div class="panel-body">
                    <a href="">Check for update</a>
                </div>
            </div>
        </div>
    </div>
@endsection
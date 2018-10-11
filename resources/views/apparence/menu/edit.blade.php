@extends('layouts.app')

@push('scripts')
    <script src="{{ asset('js/jquery.nestable.js') }}" language="JavaScript"></script>
    <script src="{{ asset('js/custom.nestable.js') }}" language="JavaScript"></script>
    <script src="{{ asset('js/omega/admin/apparance/menu/edit.js') }}" language="JavaScript"></script>
@endpush

@php
$overflow = 150;
@endphp

@section('content')
<h1 class="page-header">{{ __('Menu editor') }}
    @if(!$menu->isEnabled)
        <small> {{ __('Menu disabled') }}</small>
    @endif
</h1>
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ __('Menu') }}
            </div>
            <div class="panel-body">
                <div class="dd" id="nestable" data-menu-id="{{ $menu->id }}">
                    @if($menu->json != '[]')

						@php
                        function genHtmlAdmin($array) {
                            if(!isset($array)){
                            return '<ol class="dd-list">'.__('No element').'</ol>';
                            }

                            $html = '<ol class="dd-list">';
                            $length = count($array);
                            //foreach($array as $row)
                            for ($i = 0; $i < $length; $i++)
                            {
                                $html .= '
                                    <li class="dd-item">
                                        <a class="remove" href="#">
                                            <span class="glyphicon glyphicon-trash" style="float:right; position:absolute; right:5px; top:7px; cursor:pointer;"></span>
                                        </a>
                                        <a class="edit" data-url="'.$array[$i]['url'].'" data-title="'.$array[$i]['title'].'" href="#">
                                            <span class="glyphicon glyphicon-cog" style="float:right; position:absolute; right:25px; top:7px; cursor:pointer;"></span>
                                        </a>
                                        <div class="dd-handle">'.$array[$i]['title'].'</div>';
                                if(array_key_exists('children', $array[$i]))
                                {
                                    $html .= genHtmlAdmin($array[$i]['children']);
                                }
                                $html .= '</li>';
                            }
                            $html .= '</ol>';
                            return $html;
                            //array_key_exists ( mixed $key , array $array )
                        }
                        @endphp

						{!! genHtmlAdmin(json_decode($menu->json, true)) !!}
					@else

                        <ol class="dd-list">{{ __('No element') }}</ol>

                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ __('All pages') }}
                    </div>
                    <div class="panel-body">
                        <div style="height:{{ $overflow }}px;overflow:auto;" id="list-pages">
                            Loading ...
                        </div>
                        <br />
                        <p><input type="submit" data-action="add_page" class="btn btn-primary btn-block btn-add-element" value="{{ __('Add element') }}" /></p>
                        <p><input name="checkAll" id="chkAll" type="checkbox" /> <label for="chkAll">{{ __('Toggle all') }}</label></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ __('External link') }}
                    </div>
                    <div class="panel-body">
                        <div style="height:{{ $overflow }}px;overflow:auto;">
                            <input type="text" id="link" class="form-control" placeholder="http://" /><br />
                            <input type="text" id="title" class="form-control" placeholder="Title" />
                        </div><br />
                        <p><input type="submit" data-action="add_link" class="btn btn-primary btn-block btn-add-element" value="{{ __('Add element') }}" /></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ __('Webparts') }}
                    </div>
                    <div class="panel-body">
                        <div style="height:{{ $overflow }}px;overflow:auto;" id="list-webpart">
                            {{--
                            @foreach($webparts as $m)
                                @foreach($m[1] as $action): }}
                            <div>
                                <input name="module[]" type="checkbox" data-title="{{ $m[0] }} - {{ ucfirst($action) }}" data-url="{{ PController::Url($m[0], $action) }}" />
                                <label >{{ $m[0] }} - {{ ucfirst($action) }}</label>
                            </div>
                                @endforeach
                            @endforeach
                            --}}
                        </div><br />
                        <p><input type="submit" data-action="add_module" class="btn btn-primary btn-block btn-add-element" value="{{ __('Add element') }}" /></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ __('Actions') }}
            </div>
            <div class="panel-body">
                <p><a href="#" class="btn btn-info btn-block" id="edit">{{ __('Save') }}</a></p>
                @if($menu->isEnabled)
                    <p><a href="{{ route('menu.enable', ['id' => $menu->id, 'enable' => 0]) }}" class="btn btn-warning btn-block">{{ __('Disable') }}</a></p>
                @else
                    <p><a href="{{ route('menu.enable', ['id' => $menu->id, 'enable' => 1]) }}" class="btn btn-success btn-block">{{ __('Enable') }}</a></p>
                @endif
                <p><a href="{{ route('menu.delete', ['id' => $menu->id]) }}" data-url="{{ route('menu.delete', ['id' => $menu->id, 'confirm' => 1]) }}" class="btn btn-danger btn-block" class="delete">{{ __('Delete') }}</a></p>
                <p><a href="{{ route('menu.index') }}" class="btn btn-default btn-block">{{ __('Cancel') }}</a></p>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ __('Informations') }}
            </div>
            <div class="panel-body">
                <div class="form-group">
                    {{ Form::label('name', __('Name'), ['class' => 'control-label']) }}
                    {{ Form::text('name', $menu->name, ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {{ Form::label('description', __('Description'), ['class' => 'control-label']) }}
                    {{ Form::textarea('description', $menu->description, ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            {{ Form::hidden('isMain', 0) }}
                            {{ Form::checkbox('isMain', 1, $menu->isMain, ['id' => 'isMain']) }}
                            {{ __('Is Main menu') }}
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('membergroup', __('Membergroup', ['class' => 'control-label'])) }}
                    {{ Form::select('membergroup', $membergroups, $menu->membergroup, ['class' => 'form-control']) }}
                </div>
                @if($langEnabled)
                    <div class="form-group">
                        {{ Form::label('lang', __('Languages', ['class' => 'control-label'])) }}
                        {{ Form::select('lang', $langs, $menu->lang, ['class' => 'form-control']) }}
                    </div>
                @else
                    {{ Form::hidden('lang', null) }}
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
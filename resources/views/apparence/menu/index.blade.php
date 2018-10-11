@extends('layouts.app')

@section('content')
    <h1 class="page-header">{{ __('All menus') }} <a href="{{ route('menu.add') }}" class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-plus-sign"></span> {{ __('Add new') }}</a></h1>
    <div class="alert alert-info">
        <strong><i class="fa fa-info-circle"></i></strong> {{ __('menuindex_tips') }}
    </div>
    <table class="table table-hover">
        <tr>
            <th>#</th>
            <th>{{ __('Name') }}</th>
            <th>{{ __('Description') }}</th>
            <th>{{ __('Membergroup') }}</th>
            @if($langEnabled)
                <th>{{ __('Language') }}</th>
            @endif
            <th></th>
        </tr>
        @if(sizeof($menus) == 0)
        <tr><td colspan="4" align="center">No menu <a href="{{ route('menu.add') }}" class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-plus-sign"></span> {{ __('Add new') }}</a></td></tr>
        @else
            @foreach($menus as $menu)
            <tr>
                <td width="10px">{!! $menu->isMain ? '<span class="glyphicon glyphicon-home"></span>' : '' !!}</td>
                <td><a href="{{ route('menu.edit', ['id' => $menu->id]) }}">{{ $menu->name }}</a></td>
                <td>{{ $menu->description }}</td>
                <td>{{ $menu->membergroup->name }}</td>
                @if($langEnabled)
                <td>{{ $menu->lang }}</td>
                @endif
                <td>
                        <span class="action-img-page-list">
                            <a  href="{{ route('menu.edit', ['id' => $menu->id])  }}"
                                title="{{ __('Edit') }}">{{ __('Edit') }}</a>
                            |
                            <a  href="{{ route('menu.delete', ['id' => $menu->id])  }}"
                                title="{{ __('Delete') }}"
                                data-url="{{ route('menu.delete', ['id' => $menu->id, 'confirm' => 1]) }}"
                                class="delete text-danger">{{ __('Delete') }}</a>
                        </span>
                </td>
            </tr>
            @endforeach
        @endif
    </table>
@endsection
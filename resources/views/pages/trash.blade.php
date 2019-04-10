@extends('layouts.app')


@section('content')
    <h1 class="page-header">{{ __('Pages trash') }}</h1>

    <div class="row">
        <div class="col-sm-12 pull">
            <p class="text-right">
                <a href="{{ route('admin.pages') }}" class="btn btn-default btn-tooltip" title="{{ __('Back to the list of pages') }}">
                    <i class="fa fa-list"></i> {{ __('Back to pages') }}
                </a>
            </p>
        </div>

    </div>

    <div class="alert alert-info">
        <strong><i class="fa fa-info"></i> {{ __('Information') }}</strong>
        {{ __('Here you can restore or permanently delete  deleted pages') }}
    </div>

    <table class="table table-condensed">
        <tr>
            <th>{{ __('Title') }}</th>
            <th>{{ __('Deleted') }}</th>
            <th></th>
        </tr>

        @foreach($pages as $page)
            <tr class="active text-muted">
                <td style="width: 70%;">{{ $page->name }}</td>
                <td><em><small> {{ $page->deleted_at }}</small></em></td>
                <td>
                    <span class="action-img-page-list">
                        <a  href="{{ route('admin.pages.restore', ['id' => $page->id]) }}" class="text-warning"
                            title="{{ __('Restore') }}">{{ __('Restore') }}</a> |
                        <a  href="javascript:void()"
                            data-url="{{ route('admin.pages.forcedelete', ['id' => $page->id]) }}"
                            class="text-danger delete"
                            title="{{ __('Delete permanently the page') }}">{{ __('Delete permanently') }}</a>
                    </span>
                </td>
            </tr>
        @endforeach
    </table>

    <div class="text-center">
        {{ $pages->links() }}
    </div>

@endsection
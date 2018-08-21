
<table class="table">
    <tr>
        <th>{{ __('Slug') }}</th>
        <th>{{ __('Languages') }}</th>
        <th>{{ __('Flag') }}</th>
        <th>{{ __('Enabled') }}</th>
        <th>
            <span style="float:right">
                <button class="btn btn-success btn-xs" id="langf-add"><i class="fa fa-plus"></i> {{ __('Add') }}</button>
            </span>
        </th>
    </tr>
    @foreach($fallLang as $fl)
    <tr>
        <td>{{ $fl->slug }}</td>
        <td>{{ $fl->name }}</td>
        <td>

        </td>
        <td>
            {{ $fl->enabled ? __('Yes') : __('No') }}
        </td>
        <td>
                <span style="float:right">
                    <button class="btn btn-default btn-xs" id="langf-edit" data-slug="{{ $fl->slug }}"><i class="fa fa-pencil"></i> {{ __('Edit') }}</button>
                    <button class="btn btn-danger btn-xs" id="langf-delete" data-slug="{{ $fl->slug }}"><i class="fa fa-trash"></i> {{ __('Delete') }}</button>
                </span>
        </td>
    </tr>
    @endforeach
</table>
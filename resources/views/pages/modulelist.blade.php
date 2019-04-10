<table class="table table-condensed">
    @forelse($modules as $module)
        <tr>
            <td>{{ $module->name }} ({{ prettify_text($module->plugin->name) }})</td>
            <td>
                <div style="float:right">
                    <a href="#" class="editModule" data-id="{{ $module->id }}"><span class="glyphicon glyphicon-edit"></span></a>
                    <a href="#" class="deleteModule" data-id="{{ $module->id }}"><span class="glyphicon glyphicon-trash"></span></a>
                </div>
            </td>
        </tr>
    @empty
        {{ __('Any modules') }}...
    @endforelse
</table>
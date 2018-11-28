<table class="table table-condensed">
    @if(sizeof($modules) == 0)
        {{ __('Any modules') }}...
    @else
    @foreach($modules as $module)
    <tr>
        <td>{{ $module->name }} ({{ prettify_text($module->plugin->name) }})</td>
        <td>
            <div style="float:right">
                <a href="#" class="editModule" data-id="{{ $module->id }}"><span class="glyphicon glyphicon-edit"></span></a>
                <a href="#" class="deleteModule" data-id="{{ $module->id }}"><span class="glyphicon glyphicon-trash"></span></a>
            </div>
        </td>
    </tr>
    @endforeach
    @endif
</table>
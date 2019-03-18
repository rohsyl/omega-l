

<table class="table table-condensed">
@foreach($moduleArea as $ma)
    <tr>
        <td>{{ $ma->name }}</td>
        <td class="text-right">
            @if(has_right('theme_modulearea'))
            <a href="{{ route('theme.detail.ma.delete', ['name' => $theme, 'area' => $ma->name]) }}" class="deleteModulearea text-danger"><i class="fa fa-trash"></i></a>
            @endif
        </td>
    </tr>
@endforeach
</table>
<script src="{{ asset('js/omega/admin/theme/moduleareaList.js') }}"></script>
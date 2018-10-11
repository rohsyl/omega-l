

<table class="table table-condensed">
@foreach($moduleArea as $ma)
    <tr>
        <td>{{ $ma->name }}</td>
        <td class="text-right">
            <a href="{{ route('theme.detail.ma.delete', ['name' => $theme, 'area' => $ma->name]) }}" class="deleteModulearea text-danger"><i class="fa fa-trash"></i></a>
        </td>
    </tr>
@endforeach
</table>
<script src="{{ asset('js/omega/admin/theme/moduleareaList.js') }}"></script>
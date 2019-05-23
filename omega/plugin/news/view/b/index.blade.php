@extends('layouts.plugin')

@section('plugin_content')
{!! $menu !!}
<table class="table">
	<tr>
		<th>{{ __('Title') }}</th>
		<th>{{ __('Publish date') }}</th>
        <th>{{ __('Categories') }}</th>
		<th></th>
	</tr>
	@foreach($posts as $p)
	<tr>
		<td>{{ $p->title }}</td>
		<td>{{ isset($p->published_at) ? $p->published_at : '' }}</td>
        <td>
            @php
                $i = 0;
                $size = sizeof($p->categories);
                foreach($p->categories as $c) {
                    echo $c->name;

                    if($i < $size - 1)
                        echo ', ';
                    $i++;
                }
            @endphp
        </td>
		<td>
            <span class="action-img-page-list">
				<a href="{{ route_plugin('news', 'edit', ['id' => $p->id]) }}"><span class="glyphicon glyphicon-pencil"></span></a>
				<a href="{{ route_plugin('news', 'delete', ['id' => $p->id]) }}"
				   data-url="{{ route_plugin('news', 'delete', ['id' => $p->id]) }}" class="delete"><span class="glyphicon glyphicon-trash"></span></a>
			</span>
		</td>
	</tr>
	@endforeach
</table>
@endsection
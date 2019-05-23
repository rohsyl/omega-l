@extends('layouts.plugin')

@section('plugin_content')
	{!! $menu !!}

	<table class="table">
		<tr>
			<th>{{ __('Name') }}</th>
			<th></th>
		</tr>
		@foreach($categories as $category)
		<tr>
			<td>{{ $category->name }}</td>
			<td>
				<span class="action-img-page-list">
					<a href="{{ route_plugin('news', 'editcategory', ['id' => $category->id]) }}"><span class="glyphicon glyphicon-pencil"></span></a>
					<a href="{{ route_plugin('news', 'deletecategory', ['id' => $category->id]) }}" data-url="{{ route_plugin('news', 'deletecategory', ['id' => $category->id]) }}" class="delete"><span class="glyphicon glyphicon-trash"></span></a>
				</span>
			</td>
		</tr>
		@endforeach
	</table>

@endsection
@php
	$path = parse_url(url()->current(), PHP_URL_PATH);
    $pathFragments = explode('/', $path);
    $action = end($pathFragments);
@endphp

<br />
<ul class="nav nav-pills">
	<li @if($action == 'index') class="active" @endif>
		<a href="{{ route_plugin('news', 'index') }}"><span class="glyphicon glyphicon-list"></span> {{ __('Posts') }}</a>
	</li>
    <li @if($action == 'add') class="active" @endif>
        <a href="{{ route_plugin('news', 'add') }}"><span class="glyphicon glyphicon-plus"></span> {{ __('Add post') }}</a>
    </li>
	<li @if($action == 'categories') class="active" @endif>
		<a href="{{ route_plugin('news', 'categories') }}"><span class="glyphicon glyphicon-list"></span> {{ __('Categories') }}</a>
	</li>
    <li @if($action == 'addcategory') class="active" @endif>
        <a href="{{ route_plugin('news', 'addcategory') }}"><span class="glyphicon glyphicon-plus"></span> {{ __('Add category') }}</a>
    </li>
</ul>
<hr />
<br />
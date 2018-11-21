<option value="">{{ __('No parent') }}</option>
@foreach($pages as $page)
<option value="{{ $page->id }}">{{ $page->name }}</option>
@endforeach
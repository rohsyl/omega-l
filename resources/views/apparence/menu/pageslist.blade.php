@if(sizeof($pages) == 0)
    {{ __('No pages') }}
@else
    @foreach($pages as $page): ?>
        <div>
            {{ Form::checkbox('pages[]', $page->slug, false, ['id' => $page->id, 'data-alias' => $page->slug]) }}
            {{ Form::label($page->id, $page->name)  }}
        </div>
    @endforeach
@endif
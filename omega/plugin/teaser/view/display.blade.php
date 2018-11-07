<div class="teaser teaser-item">
    @if(isset($link) && !empty($link))
        <a href="{{ $link }}">
    @endif


    @if(isset($image))
        <img class="teaser-image" src="{{ asset($image->path) }}" />
    @endif

    <div class="teaser-title">
        {{ $title }}
    </div>

    <div class="teaser-text">
        {!! $text !!}
    </div>


    @if(isset($link) && !empty($link))
        </a>
    @endif
</div>
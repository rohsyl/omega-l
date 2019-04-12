<div
        @if(isset($background))
            class="banner-background"
            style="background-image: url('{{ asset($background->path) }}')"
        @else
            class="banner-background no-background"
        @endif
>
    <h2 class="banner-title">{{ $title }}</h2>
    <p class="banner-text">{!! $text !!}</p>

    @if( !empty($action_text))
        <a href="{{ $action }}" class="btn button banner-button">{{ $action_text }}</a>
    @endif
</div>
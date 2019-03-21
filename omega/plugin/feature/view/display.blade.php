<div class="text-center">
    <a href="{{ isset($link) && !empty($link) ? $link : '#' }}" class="plugin-feature-link">
        @if(isset($image->id))
            <div class="service-logo plugin-feature-img" style="background-image: url('{{ asset($image->path) }}')">
            </div>
        @endif
    </a>
    <h4 class="service-heading plugin-feature-title">{{ $title }}</h4>
    <div class="text-muted plugin-feature-description">{!! $text !!}</div>
</div>
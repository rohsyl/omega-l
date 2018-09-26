<li>
    <a href="{{ sizeof($subaction) == 0 ? $url : '#' }}">
        <span class="{{ $icon }}"></span>
        {{ $text }}
        @if(isset($subaction) && sizeof($subaction) > 0)
            <span class="fa arrow"></span>
        @endif
    </a>
    @if(isset($subaction) && sizeof($subaction) > 0)
    <ul class="nav nav-second-level">
        @foreach($subaction as $sub)
            {!! $sub !!}
        @endforeach
    </ul>
    @endif
</li>
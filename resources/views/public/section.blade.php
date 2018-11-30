<section
@if(isset($compId)) {!! $compId !!}  @endif
@if(isset($style)) {!! $style !!} @endif
class="component-container">
    <div class="plugin plugin-{{ $plugin->name }}">
        @if($isWrapped)
            <div class="om-wrapper">
        @endif
        {!! $content !!}
        @if($isWrapped)
            </div>
        @endif
    </div>
</section>
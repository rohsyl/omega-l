<section
@if(isset($compId)) {{ $compId }} @endif
@if(isset($style)) {{ $style }} @endif
class="component-container">
    @if($isWrapped)
        <div class="om-wrapper">
    @endif
    {!! $content !!}
    @if($isWrapped)
        </div>
    @endif
</section>
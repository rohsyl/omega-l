@if(isset($picture)) 
    @if(isset($parallax['parallax']) && $parallax['parallax'])
        <div class="parallax-window"
             style="min-height: {{ isset($parallax_height) ? $parallax_height : 400 }}px"
             data-parallax="scroll"
             data-image-src="{{ asset($picture->path) }}"></div>
    @else 
       <div class="image-container">
           <img src="{{ asset($picture->path) }}" alt="{{ $picture->name }}"  />
       </div>
    @endif
@endif
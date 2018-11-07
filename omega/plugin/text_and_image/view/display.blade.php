<div class="plugin plugin-textandimage">
@php
    if(!function_exists('textandimage_display_text')){
        function textandimage_display_text($text) {
            echo '<div class="plugin-textandimage-text">';
            echo $text;
            echo '</div>';
        }
    }

    if(!function_exists('textandimage_display_image')){
        function textandimage_display_image($picture, $resize, $w, $h) {
            if(isset($picture)){
                echo '<div class="plugin-textandimage-image">';
                if($resize) {
                    echo '<img src="'.$picture->GetThumbnail($w, $h).'" alt="'.$picture->name.'" width="100%" />';
                }
                else{
                    echo '<img src="'.asset($picture->path).'" alt="'.$picture->name.'" width="100%" />';
                }
                echo '</div>';
            }
        }
    }

    $image_width = $width_percent['value'];
    $position = $position['value'];
    $resize = $resize['resize'];
	$LEFT = 0;
	$RIGHT = 1;
	$TOP = 2;
	$BOTTOM = 3;

	$width = intval($width);
	$height = intval($height);
@endphp

@if($position == $TOP)
	{!! textandimage_display_image($picture, $resize, $width, $height) !!}
	{!! textandimage_display_text($text) !!}
	@elseif($position == $BOTTOM)
    {!! textandimage_display_text($text) !!}
	{!! textandimage_display_image($picture,$resize, $width, $height) !!}
@elseif($position == $LEFT)
	<div class="row">
		<div class="col-sm-{{ $image_width }}">
			{!! textandimage_display_image($picture, $resize, $width, $height) !!}
		</div>
		<div class="col-sm-{{ 12 - $image_width }}">
            {!! textandimage_display_text($text) !!}
		</div>
	</div>
@elseif($position == $RIGHT)
	<div class="row">
		<div class="col-sm-{{ 12 - $image_width }}">
            {!! textandimage_display_text($text) !!}
		</div>
		<div class="col-sm-{{ $image_width }}">
			{!! textandimage_display_image($picture, $resize, $width, $height) !!}
		</div>
	</div>
@endif
</div>

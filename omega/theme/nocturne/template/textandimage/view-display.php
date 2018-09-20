<?php
    if(!function_exists('textandimage_display_text')){
        function textandimage_display_text($text) {
            echo $text;
        }
    }

    if(!function_exists('textandimage_display_image')){
        function textandimage_display_image($picture, $resize, $w, $h) {
            if(isset($picture)){
                if($resize) {
                    echo '<img src="'.$picture->GetThumbnail($w, $h).'" alt="'.$picture->name.'" width="100%" />';
                }
                else{
                    echo '<img src="'.$picture->path.'" alt="'.$picture->name.'" width="100%" />';
                }
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
?>

<?php if($position == $TOP) : ?>

    <div class="video col">
        <div class="image fit">
        <?php textandimage_display_image($picture, $resize, $width, $height) ?>
        </div>
        <div class="caption">
        <?php textandimage_display_text($text) ?>
        </div>
    </div>
<?php elseif($position == $BOTTOM) : ?>
    <?php textandimage_display_text($text) ?>
	<?php textandimage_display_image($picture,$resize, $width, $height) ?>
<?php elseif($position == $LEFT) : ?>
	<div class="row">
		<div class="col-sm-<?php echo $image_width ?>">
			<?php textandimage_display_image($picture, $resize, $width, $height) ?>
		</div>
		<div class="col-sm-<?php echo 12 - $image_width ?>">
            <?php textandimage_display_text($text) ?>
		</div>
	</div>
<?php elseif($position == $RIGHT) : ?>
	<div class="row">
		<div class="col-sm-<?php echo 12 - $image_width ?>">
            <?php textandimage_display_text($text) ?>
		</div>
		<div class="col-sm-<?php echo $image_width ?>">
			<?php textandimage_display_image($picture, $resize, $width, $height) ?>
		</div>
	</div>
<?php endif ?>


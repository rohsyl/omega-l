<?php
use Omega\Library\Entity\Media;
?>

<?php
global $carouselHeight;
$carouselHeight = 500;
if(!function_exists('gallery_get_image')){
    function gallery_get_image($media){
        global  $carouselHeight;
        $imageWidth = $media->getWidth();
        $imageHeight = $media->getHeight();
        $thumbnailWidth = round($carouselHeight / $imageHeight * $imageWidth);
        ?>
        <div class="item" style="width:<?php echo $thumbnailWidth ?>;">
            <picture>
                <source srcset="<?php echo $media->GetThumbnail($carouselHeight, $carouselHeight) ?>" media="(max-width: 768px)">
                <img src="<?php echo $media->GetThumbnail($thumbnailWidth, $carouselHeight) ?>" />
            </picture>
        </div>
        <?php
    }
}
?>

<div class="plugin plugin-gallery" data-plugin-placement="content">
    <?php if(isset($medias)) : ?>
    <div class="owl-carousel owl-carousel-image <?php echo $this->unique('slider') ?>">
        <?php foreach($medias as $mediaItem) : ?>

            <?php
            $m = new Media($mediaItem['id']);
            $mType = $m->getType();
            if($mType == Media::T_PICTURE){
                gallery_get_image($m);
            }
            elseif($mType == Media::T_FOLDER){
                $children = $m->getChildren(array(Media::T_VIDEO_EXT, Media::T_PICTURE));
                foreach($children as $media){
                    gallery_get_image($media);
                }
            }
            ?>
        <?php endforeach ?>
    </div>
    <script>
        $(function(){
            $(".<?php echo $this->unique('slider') ?>").owlCarousel({
                margin: 10,
                loop:true,
                autoWidth:true,
                autoplay:true,
                autoplayTimeout:5000,
                autoplayHoverPause:false,
                nav: true,
                items:1,
                responsive : {
                    0 : {
                        navText: [
                            '<span class="carousel-nav left"><i class="fa fa-chevron-circle-left fa-3x"></i></span>',
                            '<span class="carousel-nav right"><i class="fa fa-chevron-circle-right fa-3x"></i></span>'
                        ],
                        autoWidth:false,
                        autoplay:false,
                        margin: 0,
                        items : 1
                    },
                    768 : {
                        navText: [
                            '<span class="carousel-nav left"><i class="fa fa-chevron-circle-left fa-5x"></i></span>',
                            '<span class="carousel-nav right"><i class="fa fa-chevron-circle-right fa-5x"></i></span>'
                        ],
                        autoWidth:true,
                        items : 6
                    }
                }
            });
        });
    </script>
    <?php else : ?>
        Nothing to display... slider
    <?php endif ?>


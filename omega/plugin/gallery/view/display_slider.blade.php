

@php
global $carouselHeight;
$carouselHeight = 500;
if(!function_exists('gallery_get_image_slider')){
    function gallery_get_image_slider($media){
        global  $carouselHeight;
        $imageWidth = $media->getWidth();
        $imageHeight = $media->getHeight();
        $thumbnailWidth = round($carouselHeight / $imageHeight * $imageWidth);

        return '
        <div class="item" style="width:'. $thumbnailWidth . '">
            <picture>
                <source srcset="' . $media->GetThumbnail($carouselHeight, $carouselHeight) . '" media="(max-width: 768px)">
                <img src="' . $media->GetThumbnail($thumbnailWidth, $carouselHeight) . '" />
            </picture>
        </div>';
    }
}
@endphp

<div class="plugin plugin-gallery" data-plugin-placement="content">
    @if(isset($medias))
    <div class="owl-carousel owl-carousel-image {{ $unique('slide') }}">
        @foreach($medias as $mediaItem)

            @php
            // TODO : Display video_ext type
            $m = \Omega\Utils\Entity\Media::Get($mediaItem['id']);
            $mType = $m->getType();
            if($mType == \Omega\Utils\Entity\Media::T_PICTURE){
                echo gallery_get_image_slider($m);
            }
            elseif($mType == \Omega\Utils\Entity\Media::T_FOLDER){
                $children = $m->getChildren([
                    //\Omega\Utils\Entity\Media::T_VIDEO_EXT,
                    \Omega\Utils\Entity\Media::T_PICTURE
                ]);
                foreach($children as $media){
                    echo gallery_get_image_slider($media);
                }
            }
            @endphp
        @endforeach
    </div>
    <script>
        $(function(){
            $(".{{ $unique('slide') }}").owlCarousel({
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
    @else
        Nothing to display... slider
    @endif


@php
if(!function_exists('gallery_get_image')){
    function gallery_get_image($media){
            //$originalWidth = PictureHelper::GetImageWidth(ABSPATH.$media->path);
            //$originalHeight = PictureHelper::GetImageHeight(ABSPATH.$media->path);
            $width = 400;
            $height = 265;//$width / $originalWidth * $originalHeight;
        return '
            <a href="'. asset($media->path) .'" title="' . (isset($media->title) ? $media->title : $media->name) . '">
                <img src="' . $media->GetThumbnail($width, $height) . '" alt="' . (isset($media->title) ? $media->title : $media->name) . '">
            </a>';
    }
}
if(!function_exists('gallery_get_video_thumbnail')){
    function gallery_get_video_thumbnail($video){
        $video->readurl();
        return '
            <a  href="' . $video->path . '"
                title="' . $video->title . '"
                type="text/html"
                data-poster="' . $video->getVideoThumbnail() . '"
                ' . ($video->getPlateform() == \Omega\Utils\Entity\VideoExternal::TYPE_YOUTUBE
                    ? 'data-youtube="' . $video->getVideoId() . '"'
                    : 'data-vimeo="' . $video->getVideoId() . '"'
                ) . '>
                <img src="' . $video->getVideoThumbnail() . '" alt="' . $video->title . '">
            </a>';
    }
}
@endphp

<div class="plugin plugin-gallery" data-plugin-placement="content">
@if(isset($medias))
    <div id="{{ $unique('gallery') }}" class="blueimp-gallery">
        <div class="slides"></div>
        <h3 class="title"></h3>
        <a class="prev">‹</a>
        <a class="next">›</a>
        <a class="close">×</a>
        <a class="play-pause"></a>
        <ol class="indicator"></ol>
    </div>
    <div id="{{ $unique('links') }}" class="links">
        @foreach($medias as $mediaItem)
            @php
                $m = \Omega\Utils\Entity\Media::Get($mediaItem['id']);
                $mType = $m->getType();
                if($mType == \Omega\Utils\Entity\Media::T_PICTURE){
                    echo gallery_get_image($m);
                }
                elseif($mType == \Omega\Utils\Entity\Media::T_VIDEO_EXT){
                    $v = new \Omega\Utils\Entity\VideoExternal($m);

                    echo gallery_get_video_thumbnail($v);
                }
                elseif($mType == \Omega\Utils\Entity\Media::T_FOLDER){
                    $children = $m->getChildren(array(\Omega\Utils\Entity\Media::T_VIDEO_EXT, \Omega\Utils\Entity\Media::T_PICTURE));
                    foreach($children as $media){
                        echo gallery_get_image($media);
                    }
                }
                @endphp
        @endforeach
    </div>
    <script>
        document.getElementById('{{ $unique('links') }}').onclick = function (event) {
            event = event || window.event;
            var target = event.target || event.srcElement,
                link = target.src ? target.parentNode : target,
                options = {index: link, event: event, container: '#{{ $unique('gallery') }}'},
                links = this.getElementsByTagName('a');
            blueimp.Gallery(links, options);
        };
    </script>
@else
    Nothing to display...
@endif
</div>
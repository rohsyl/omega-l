@php
    if(!function_exists('gallery_bigslider_get_image')){
        function gallery_bigslider_get_image($media){
            return [
                'title' => (isset($media->title) ? $media->title : $media->name),
                'href' => asset($media->path),
                'type' =>'image/jpeg'
            ];
            /*'
                <a href="'. .'" title="' .  . '">
                    <img src="' . $media->GetThumbnail($width, $height) . '" alt="' . (isset($media->title) ? $media->title : $media->name) . '">
                </a>';*/
        }
    }
    if(!function_exists('gallery_bigslider_get_video_thumbnail')){
        function gallery_bigslider_get_video_thumbnail($video){
            $video->readurl();
            $item = [
                'title' => (isset($video->title) ? $video->title : $video->name),
                'href' => $video->path,
                'type' =>'text/html',
                'poster' => asset($video->getVideoThumbnail())
            ];
            if($video->getPlateform() == \Omega\Utils\Entity\VideoExternal::TYPE_YOUTUBE){
                $item['youtube'] = $video->getVideoId();
            }
            else{
                $item['vimeo'] = $video->getVideoId();
            }
            return $item;
        }
    }
@endphp

<div class="plugin plugin-gallery" data-plugin-placement="content">
    @if(isset($medias))
        <div id="{{ $unique('gallery') }}" class="blueimp-gallery blueimp-gallery-carousel" height="500">
            <div class="slides"></div>
            <h3 class="title"></h3>
            <a class="prev">‹</a>
            <a class="next">›</a>
            <a class="play-pause"></a>
            <ol class="indicator"></ol>
        </div>
        @php
        $items = [];
        @endphp
        @foreach($medias as $mediaItem)
            @php
                $m = \Omega\Utils\Entity\Media::Get($mediaItem['id']);
                $mType = $m->getType();
                if($mType == \Omega\Utils\Entity\Media::T_PICTURE){
                    $items[] = gallery_bigslider_get_image($m);
                }
                elseif($mType == \Omega\Utils\Entity\Media::T_VIDEO_EXT){
                    $v = new \Omega\Utils\Entity\VideoExternal($m);

                    $items[] = gallery_bigslider_get_video_thumbnail($v);
                }
                elseif($mType == \Omega\Utils\Entity\Media::T_FOLDER){
                    $children = $m->getChildren(array(\Omega\Utils\Entity\Media::T_VIDEO_EXT, \Omega\Utils\Entity\Media::T_PICTURE));
                    foreach($children as $media){
                        $type = $media->getType();
                        if($type == \Omega\Utils\Entity\Media::T_PICTURE){
                            $items[] = gallery_bigslider_get_image($media);
                        }
                        elseif($type == \Omega\Utils\Entity\Media::T_VIDEO_EXT){
                            $v = new \Omega\Utils\Entity\VideoExternal($media);

                            $items[] = gallery_bigslider_get_video_thumbnail($v);
                        }

                    }
                }
            @endphp
        @endforeach
        <script>
            var options = {
                    container: '#{{ $unique('gallery') }}',
                    carousel: true
                },
                links = {!! json_encode($items) !!}
            blueimp.Gallery(links, options);
        </script>
    @else
        Nothing to display...
    @endif
</div>
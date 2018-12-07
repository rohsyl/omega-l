@php
    if(!function_exists('gallery_bigslider_get_image')){
        function gallery_bigslider_get_image($media){
            return [
                'title' => (isset($media->title) ? $media->title : $media->name),
                'href' => asset($media->path),
                'type' =>'image'
            ];
        }
    }
    if(!function_exists('gallery_bigslider_get_video_thumbnail')){
        function gallery_bigslider_get_video_thumbnail($video){
            $video->readurl();
            $item = [
                'title' => (isset($video->title) ? $video->title : $video->name),
                'href' => $video->path,
                'type' =>'video',
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

@php
    $hasVideo = false;
    $items = [];
@endphp
@if(isset($medias))
    @foreach($medias as $mediaItem)
        @php
            $m = \Omega\Utils\Entity\Media::Get($mediaItem['id']);
            $mType = $m->getType();
            if($mType == \Omega\Utils\Entity\Media::T_PICTURE){
                $items[] = gallery_bigslider_get_image($m);
            }
            elseif($mType == \Omega\Utils\Entity\Media::T_VIDEO_EXT){
                $v = new \Omega\Utils\Entity\VideoExternal($m);
                $hasVideo = true;
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
                        $hasVideo = true;
                        $items[] = gallery_bigslider_get_video_thumbnail($v);
                    }

                }
            }
        @endphp
    @endforeach
@endif

<div class="plugin plugin-gallery" data-plugin-placement="content">
    @if(sizeof($items) > 0)
        <div id="{{ $unique('carousel') }}" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                @for($i = 0; $i < sizeof($items); $i++)
                <li data-target="#{{ $unique('carousel') }}" data-slide-to="{{ $i }}" class="{{ $i == 0 ? 'active' : '' }}"></li>
                @endfor
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                @php $i = 0; @endphp
                @foreach($items as $item)
                    <div class="carousel-item item {{ $i == 0 ? 'active' : '' }}" data-id="{{ $i }}">
                        @php

                        @endphp
                        @if($item['type'] == 'image')
                            <div class="linkedSlider-image-container">
                                <div class="linkedSlider-image" style="background-image: url('{{ $item['href'] }}');"></div>
                            </div>
                        @else
                            <div class="toggle-mute"><span class="glyphicon glyphicon-volume-up"></span></div>
                            <div id="player-{{ $i }}">
                            </div>
                            <script>
                                var slideId{{ $i }} = {{ $i }};
                                var player{{ $i }};
                                function onYouTubeIframeAPIReady() {
                                    player{{ $i }} = new YT.Player('player-{{ $i }}', {
                                        height: '100%',
                                        width: '100%',
                                        videoId: '{{ $item['youtube'] }}',
                                        events: {
                                            'onReady': onPlayerReady
                                        },
                                        playerVars: {
                                            'autoplay': 0,
                                            'controls': 0,
                                            'rel' : 0,
                                            'showinfo': 0
                                        }
                                    });
                                }
                                function onPlayerReady(e) {
                                    if(slideId{{ $i }} == getCurrentSlideId()) {
                                        e.target.playVideo();
                                    }
                                }
                                function playVideo(){
                                    player{{ $i }}.playVideo();
                                }
                                function stopVideo() {
                                    player{{ $i }}.stopVideo();
                                }

                                $('#{{ $unique('carousel') }}').on('slid.bs.carousel', function () {
                                    console.log(getCurrentSlideId());
                                    if(slideId{{ $i }} == getCurrentSlideId()) {
                                        playVideo();
                                    }
                                });
                                $(function(){
                                    $('.toggle-mute').click(function(){
                                        if(player{{ $i }}.isMuted()){
                                            player{{ $i }}.unMute();
                                            $(this).find('span').removeClass('glyphicon-volume-off');
                                            $(this).find('span').addClass('glyphicon-volume-up');
                                            console.log('u mute');
                                        }
                                        else{
                                            player{{ $i }}.mute();
                                            $(this).find('span').removeClass('glyphicon-volume-up');
                                            $(this).find('span').addClass('glyphicon-volume-off');
                                            console.log('mute');
                                        }
                                    });
                                });
                            </script>
                        @endif

                    </div>
                    @php $i++ @endphp
                @endforeach
            </div>


            <!-- Controls -->
            <a class="carousel-control-prev" href="#{{ $unique('carousel') }}" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#{{ $unique('carousel') }}" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <script>
            $(function(){
                $('#{{ $unique('carousel') }}').carousel({
                    interval: false
                });

                $(window).resize(function() {
                    $('#{{ $unique('carousel') }} .item').height($(window).height() - $('#{{ $unique('carousel') }}').offset().top);
                });
                $(window).resize();
            });
            @if($hasVideo)
            var tag = document.createElement('script');
            tag.src = "https://www.youtube.com/iframe_api";
            var firstScriptTag = document.getElementsByTagName('script')[0];
            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
            $(function(){
                $('#{{ $unique('carousel') }}').on('slide.bs.carousel', function () {
                    stopVideo();
                })
            });
            @endif
            function getCurrentSlideId(){
                return $('.carousel .carousel-inner .item.active').data('id');
            }
        </script>

    @endif
</div>

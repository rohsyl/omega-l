<?php
use Omega\Library\Entity\Media;
?>
<?php if(isset($slides)) : ?>
    <div id="carousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <?php for($i = 0; $i < sizeof($slides); $i++) : ?>
                <li data-target="#carousel" data-slide-to="<?php echo $i ?>" class="<?php echo $i == 0 ? 'active' : '' ?>"></li>
            <?php endfor ?>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <?php $i = 0;   foreach($slides as $slide) : ?>
                <div class="item <?php echo $i == 0 ? 'active' : '' ?>" data-id="<?php echo $i ?>">
                    <?php if($slide['type'] == 'image'): ?>
                    <?php $media = new Media($slide['slide']) ?>
                    <div class="linkedSlider-image-container">
                        <!--<img src="<?php echo $media->path ?>" alt="<?php echo $media->name ?>" />-->
                        <div class="linkedSlider-image" data-link="<?php echo $slide['link'] ?>" style="background-image: url('<?php echo $media->path ?>');"></div>
                    </div>
                    <?php else: ?>
                    <div class="toggle-mute"><span class="glyphicon glyphicon-volume-up"></span></div>
                    <div id="player-<?php echo $i ?>">
                    </div>
                    <script>
                        var slideId<?php echo $i ?> = <?php echo $i ?>;
                        var player<?php echo $i ?>;
                        function onYouTubeIframeAPIReady() {
                            player<?php echo $i ?> = new YT.Player('player-<?php echo $i ?>', {
                                height: '100%',
                                width: '100%',
                                videoId: '<?php echo YoutubeUtil::GetVideoIdFromUrl($slide['url']) ?>',
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
                            if(slideId<?php echo $i ?> == getCurrentSlideId()) {
                                e.target.playVideo();
                            }
                        }
                        function playVideo(){
                            player<?php echo $i ?>.playVideo();
                        }
                        function stopVideo() {
                            player<?php echo $i ?>.stopVideo();
                        }

                        $('.carousel').on('slid.bs.carousel', function () {
                            console.log(getCurrentSlideId());
                            if(slideId<?php echo $i ?> == getCurrentSlideId()) {
                                playVideo();
                            }
                        })
                        $(function(){
                            $('.toggle-mute').click(function(){
                                if(player<?php echo $i ?>.isMuted()){
                                    player<?php echo $i ?>.unMute();
                                    $(this).find('span').removeClass('glyphicon-volume-off');
                                    $(this).find('span').addClass('glyphicon-volume-up');
                                    console.log('u mute');
                                }
                                else{
                                    player<?php echo $i ?>.mute();
                                    $(this).find('span').removeClass('glyphicon-volume-up');
                                    $(this).find('span').addClass('glyphicon-volume-off');
                                    console.log('mute');
                                }
                            });
                        });
                    </script>

                    <?php endif ?>
                    <?php
                        $hasTitle = !empty($slide['title']);
                        $hasDescr = !empty($slide['descr']);
                        $hasLink = !empty($slide['link']);
                    ?>
                    <!--<?php if($hasTitle || $hasDescr || $hasLink) : ?>
                    <div class="carousel-caption">
                        <div class="box">
                            <?php if($hasTitle) : ?>
                                <h3><?php echo $slide['title'] ?></h3>
                            <?php endif ?>
                            <?php if($hasDescr) : ?>
                                <p><?php echo $slide['descr'] ?></p>
                            <?php endif ?>
                            <?php if($hasLink) : ?>
                            <a class="btn btn-default btn-xs"
                               <?php if(!$hasTitle || !$hasDescr) echo 'style="margin-bottom : -10px"' ?>
                               href="<?php echo $slide['link'] ?>">En savoir plus <span class="glyphicon glyphicon-menu-right"></span></a>
                            <?php endif ?>
                        </div>
                    </div>
                    <?php endif ?>-->

                </div>
                <?php $i++; endforeach ?>
        </div>
        <!-- Controls -->
        <a class="left carousel-control" href="#carousel" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <script>
        $(function(){
            $('.carousel').carousel({
                interval: false
            })
            $('.linkedSlider-image').click(function(){
                window.location  = $(this).data('link');
            })
        });
        <?php if($hasVideo) : ?>
        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
        $(function(){
            $('.carousel').on('slide.bs.carousel', function () {
                stopVideo();
            })
        });
        <?php endif ?>
        function getCurrentSlideId(){
            return $('.carousel .carousel-inner .item.active').data('id');
        }
    </script>
<?php else : ?>
    No Slide
<?php endif ?>

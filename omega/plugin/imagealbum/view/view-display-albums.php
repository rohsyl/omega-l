<?php
use Omega\Library\Util\Util;
use Omega\Plugin\Imagealbum\Model\MediaImageAlbum;
?>
<div class="inner imagealbum-detail">
    <header>
        <h2><?php echo $section[SEC_NAME_F] ?></h2>
        <p><?php echo $section[SEC_DESCR] ?></p>
    </header>
    <!-- Tabbed Video Section -->
    <div class="flex flex-tabs">
        <ul class="tab-list">
            <?php $i = 0 ?>
            <?php foreach($albums as $album) : ?>
            <li><a href="#" data-tab="<?php echo Util::toTextKey($album[ALB_NAME]) ?>" <?php echo $i == 0 ? 'class="active"' : '' ?>><?php echo $album[ALB_NAME] ?> <span><?php echo date('Y', strtotime($album[ALB_YEAR])) ?></span></a></li>
            <?php $i++ ?>
            <?php endforeach; ?>
        </ul>
        <div class="tabs">
            <?php $flex = 4 ?>
            <?php $i = 0 ?>
            <?php foreach($albums as $album) : ?>
            <div class="tab <?php echo Util::toTextKey($album[ALB_NAME]) ?> flex flex-<?php echo $flex ?> <?php echo $i == 0 ? 'active' : '' ?>" id="<?php echo Util::toTextKey($album[ALB_NAME]) ?>">
                <!-- Video Thumbnail -->
                <?php foreach($album['images'] as $image): ?>
                    <?php
                    $media = new MediaImageAlbum($image[IMG_MEDIA], $album);
                    ?>
                <a href="<?php echo $cfg[CFG_COPY_EN] ? $media->getImageWithCopyRight($cfg) : $media->GetThumbnail($cfg[CFG_BIMG_W], $cfg[CFG_BIMG_H]) ?>" class="col">
                    <div class="video">
                        <div class="image fit">
                            <img src="<?php echo $media->GetThumbnail($cfg[CFG_THUMB_W], $cfg[CFG_THUMB_H]) ?>" alt="" />
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
                <?php for($i = 0; $i < $flex - sizeof($album['images']) % $flex; $i++) : ?>
                    <div class="col"></div>
                <?php endfor; ?>
            </div>
            <script>
                document.getElementById('<?php echo Util::toTextKey($album[ALB_NAME]) ?>').onclick = function (event) {
                    event = event || window.event;
                    var target = event.target || event.srcElement,
                        link = target.src ? target.parentNode : target,
                        options = {
                            index: link,
                            event: event,
                            onopen: function () {
                                // Callback function executed when the Gallery is initialized.
                                $('#header').hide();
                            },
                            onclose: function () {
                                // Callback function executed when the Gallery is about to be closed.
                                $('#header').show();
                            }
                        },
                        links = this.getElementsByTagName('a');
                    blueimp.Gallery(links, options);
                };
            </script>
            <?php $i++ ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>
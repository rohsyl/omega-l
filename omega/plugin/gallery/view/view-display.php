<?php
use Omega\Library\Entity\Media;
use Omega\Library\Entity\VideoExternal;
use Omega\Library\Util\Url;
?>

<?php
if(!function_exists('gallery_get_image')){
    function gallery_get_image($media){
            //$originalWidth = PictureHelper::GetImageWidth(ABSPATH.$media->path);
            //$originalHeight = PictureHelper::GetImageHeight(ABSPATH.$media->path);
            $width = 400;
            $height = 265;//$width / $originalWidth * $originalHeight;
        ?>
            <a href="<?php echo Url::CombAndAbs(ABSPATH, $media->path) ?>" title="<?php echo isset($media->title) ? $media->title : $media->name ?>">
                <img src="<?php echo $media->GetThumbnail($width, $height) ?>" alt="<?php echo isset($media->title) ? $media->title : $media->name ?>">
            </a>
        <?php
    }
}
if(!function_exists('gallery_get_video_thumbnail')){
    function gallery_get_video_thumbnail($video){
        $video->readurl();
        ?>
            <a  href="<?php echo $video->path ?>"
                title="<?php echo $video->title ?>"
                type="text/html"
                data-poster="<?php echo $video->getVideoThumbnail() ?>"
                <?php if($video->getPlateform() == VideoExternal::TYPE_YOUTUBE) : ?>
                    data-youtube="<?php echo $video->getVideoId() ?>"
                <?php else: ?>
                    data-vimeo="<?php echo $video->getVideoId() ?>"
                <?php endif ?>>
                <img src="<?php echo $video->getVideoThumbnail() ?>" alt="<?php echo $video->title ?>">
            </a>
        <?php
    }
}
?>

<div class="plugin plugin-gallery" data-plugin-placement="content">
<?php if(isset($medias)) : ?>
    <div id="<?php echo $this->unique('blueimp-gallery') ?>" class="blueimp-gallery">
        <div class="slides"></div>
        <h3 class="title"></h3>
        <a class="prev">‹</a>
        <a class="next">›</a>
        <a class="close">×</a>
        <a class="play-pause"></a>
        <ol class="indicator"></ol>
    </div>
    <div id="<?php echo $this->unique('links') ?>" class="links">
        <?php foreach($medias as $mediaItem) : ?>
            <?php
                $m = new Media($mediaItem['id']);
                $mType = $m->getType();
                if($mType == Media::T_PICTURE){
                    gallery_get_image($m);
                }
                elseif($mType == Media::T_VIDEO_EXT){
                    $v = new VideoExternal($mediaItem['id']);

                    gallery_get_video_thumbnail($v);
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
        document.getElementById('<?php echo $this->unique('links') ?>').onclick = function (event) {
            event = event || window.event;
            var target = event.target || event.srcElement,
                link = target.src ? target.parentNode : target,
                options = {index: link, event: event, container: '#<?php echo $this->unique('blueimp-gallery') ?>'},
                links = this.getElementsByTagName('a');
            blueimp.Gallery(links, options);
        };
    </script>
<?php else : ?>
    Nothing to display...
<?php endif ?>
</div>
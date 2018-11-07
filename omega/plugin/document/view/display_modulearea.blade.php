<?php
use Omega\Library\Entity\Media;
use Omega\Library\Util\Url;
?>


<?php
if(!function_exists('document_get_item_modulearea')){
    function document_get_item_modulearea($media){
        global $displayFilesize;
        ?>
        <div class="document-item">
            <a target="_blank" href="<?php echo Url::CombAndAbs(ABSPATH, $media->path) ?>">
                <span class="doc-icon"><i class="<?php echo getClassByExt($media->ext) ?> <?php echo getIconByExt($media->ext) ?>"></i></span>
                <span class="text">
                        <?php if(isset($media->title) && !empty($media->title)) : ?>
                            <?php echo $media->title ?>
                        <?php else : ?>
                            <?php echo $media->name.'.'.$media->ext ?>
                        <?php endif ?>
                    </span>
            </a>
        </div>
        <?php
    }
}
?>

<div class="plugin plugin-document" data-plugin-placement="modulearea">
<?php if(isset($documents)) : ?>
    <?php foreach($documents as $document) : ?>

        <?php
            $m = new Media($document['id']);
            $mType = $m->getType();
            if($mType == Media::T_FOLDER){
                $children = $m->getChildren(array(Media::T_DOCUMENT));
                foreach($children as $media){
                    document_get_item_modulearea($media);
                }
            }
            else{
                document_get_item_modulearea($m);
            }
        ?>
    <?php endforeach ?>
<?php else : ?>
    Nothing to display...
<?php endif ?>
</div>
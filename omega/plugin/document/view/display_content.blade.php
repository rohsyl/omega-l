<?php
global $displayFilesize;
$displayFilesize = $filesize['filesize'];

if(!function_exists('document_get_item_content')){
    function document_get_item_content($media){
        global $displayFilesize;
        ?>
        <div class="col-md-6 col-sm-12">
            <div class="document-item">
                <a target="_blank" href="<?php echo Url::CombAndAbs(ABSPATH, $media->path) ?>">
                    <span class="doc-icon"><i class="<?php echo getClassByExt($media->ext) ?> <?php echo getIconByExt($media->ext) ?>"></i></span>
                    <span class="text">
                        <?php if(isset($media->title) && !empty($media->title)) : ?>
                            <?php echo $media->title ?>
                            <span>
                                <?php echo $media->description ?>
                                <?php echo isset($displayFilesize) && $displayFilesize ? '('.formatBytes($media->getFilesize()).')' : '' ?>
                            </span>
                        <?php else : ?>
                            <?php echo $media->name.'.'.$media->ext ?>
                            <?php echo isset($displayFilesize) && $displayFilesize ? '<span>'.formatBytes($media->getFilesize()).'</span>' : '' ?>
                        <?php endif ?>
                    </span>
                </a>
            </div>
        </div>
        <?php
    }
}
?>

<div class="plugin plugin-document" data-plugin-placement="content">
<?php if(isset($documents)) : ?>
    <div class="row">
        <?php foreach($documents as $document) : ?>

            <?php
            $m = \Omega\Utils\Entity\Media::Get($document['id']);
            $mType = $m->getType();
            if($mType == Media::T_FOLDER){
                $children = $m->getChildren(array(Media::T_DOCUMENT));
                foreach($children as $media){
                    document_get_item_content($media);
                }
            }
            else{
                document_get_item_content($m);
            }
            ?>


            <?php /*
            <div class="col-md-6 col-sm-12">
                <?php if($document['type'] == 'media') : ?>
                    <?php $media = new Media($document['id']); ?>
                    <div class="document-item">
                        <a target="_blank" href="<?php echo Url::CombAndAbs(ABSPATH, $media->path) ?>">
                            <span class="doc-icon"><i class="<?php echo getClassByExt($media->ext) ?> <?php echo getIconByExt($media->ext) ?>"></i></span>
                            <span class="text">
                                <?php if(isset($media->title) && !empty($media->title)) : ?>
                                    <?php echo $media->title ?>
                                    <span>
                                        <?php echo $media->description ?>
                                        <?php echo isset($displayFilesize) && $displayFilesize ? '('.formatBytes($media->getFilesize()).')' : '' ?>
                                    </span>
                                <?php else : ?>
                                    <?php echo $media->name.'.'.$media->ext ?>
                                    <?php echo isset($displayFilesize) && $displayFilesize ? '<span>'.formatBytes($media->getFilesize()).'</span>' : '' ?>
                                <?php endif ?>
                            </span>
                        </a>
                    </div>
                <?php elseif($document['type'] == 'link') : ?>
                    <div class="document-item">
                        <a target="_blank" href="<?php echo $document['url'] ?>">
                            <span class="doc-icon"><i class="fa fa-link document-type link"></i></span>
                            <span class="text">
                                <?php echo $document['title'] ?>
                                <span><?php echo $document['description'] ?></span>
                            </span>
                        </a>
                    </div>
                <?php endif ?>
            </div> */ ?>
        <?php endforeach ?>
    </div>
<?php else : ?>
    Nothing to display...
<?php endif ?>
</div>
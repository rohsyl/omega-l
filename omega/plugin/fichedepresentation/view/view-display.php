<?php
    use Omega\Library\Entity\Media;
    use Omega\Library\Util\Url;
?>

<div class="row">
    <div class="4u">
        <div class="fichedepresentation-list">
            <div class="row">
                <?php foreach($articles as $article) : ?>
                    <div class="12u">
                        <?php echo $article->ref ?> - <?php echo $article->name ?>
                    </div>
                    <div class="12u">
                        <?php if(isset($article->fkMediaImage) && isset($article->fkMediaPres)) :
                            $mediaImage = new Media($article->fkMediaImage);
                            $mediaPres = new Media(($article->fkMediaPres));
                        ?>
                            <a href="<?php echo $mediaPres->path ?>" class="fichedepresentation-show-pdf" target="_blank">
                                <img src="<?php echo $mediaImage->path ?>" class="fichedepresentation-image" />
                            </a>
                        <?php else : ?>
                            No image
                        <?php endif ?>
                        <?php if(isset($article->fkMediaPanel)) :
                            $mediaPanel = new Media($article->fkMediaPanel);
                        ?>
                            <a href="<?php echo $mediaPanel->path ?>" class="fichedepresentation-show-pdf" target="_blank">
                                <div class="fichedepresentation-dmx-title">DMX</div>
                            </a>
                        <?php endif ?>
                    </div>

                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="8u">
        <p class="fichedepresentation-info">
            Veuillez choisir une fiche dans la liste</p>
        <div class="embed-responsive embed-responsive-4by3">
            <object data="" type="application/pdf" width="100%" height="800px" class="fichedepresentation-pdf-container">
                <p>It appears you don't have a PDF plugin for this browser.
                    No biggie... you can <a href="<?php echo $file->path ?>">click here to
                        download the PDF file.</a></p>
            </object>
        </div>
    </div>
</div>
<script>
    $('.fichedepresentation-show-pdf').click(function(){
        $('.fichedepresentation-info').remove();
        $('.fichedepresentation-pdf-container').attr('data', $(this).attr('href'));
        return false;
    });
</script>
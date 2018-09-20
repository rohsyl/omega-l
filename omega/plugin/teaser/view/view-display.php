<div class="teaser">
    <?php if(isset($link) && !empty($link)): ?>
        <a href="<?php echo $link ?>">
    <?php endif ?>


    <?php if(isset($image)): ?>
        <img class="teaser-image" src="<?php echo $image->path ?>" />
    <?php endif ?>


    <div class="teaser-text">
        <?php echo $text ?>
    </div>


    <?php if(isset($link) && !empty($link)): ?>
        </a>
    <?php endif ?>
</div>
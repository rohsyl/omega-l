<div class="flex flex-4 imagealbum-section">
    <?php foreach($sections as $section) : ?>
    <div class="video col">
        <div class="image fit">
            <?php
            $media = new \Omega\Library\Entity\Media($section[SEC_IMG]);
            ?>
            <img src="<?php echo $media->GetThumbnail(300, 300) ?>" alt="" />
            <p class="caption">
                <?php echo $section[SEC_NAME_S] ?>
            </p>
        </div>
        <a href="?id=<?php echo $section[SEC_ID] ?>" class="link"><span>Click Me</span></a>
    </div>
    <?php endforeach; ?>
</div>
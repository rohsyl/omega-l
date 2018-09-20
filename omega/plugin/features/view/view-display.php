<div class="text-center plugin plugin-feature">
    <a href="<?php echo isset($link) && !empty($link) ? $link : '#' ?>" class="plugin-feature-link">
        <?php if(FEATURE_USE_ICON == $radio['value']) : ?>
            <span class="fa-stack fa-5x plugin-feature-icon-stack">
                <i class="fa fa-circle fa-stack-2x plugin-feature-icon-round"></i>
                <i class="fa <?php echo $icon ?>  fa-stack-1x fa-inverse plugin-feature-icon-icon"></i>
            </span>
        <?php else : ?>
            <?php if(isset($image->id)): ?>
                <div class="service-logo plugin-feature-img" style="background-image: url('<?php echo $image->path ?>')">
                </div>
            <?php endif ?>
        <?php endif ?>
    </a>
    <h4 class="service-heading plugin-feature-title"><?php echo $title ?></h4>
    <p class="text-muted plugin-feature-description"><?php echo $text ?></p>
</div>
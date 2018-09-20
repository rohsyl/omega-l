<?php
use Omega\Library\Entity\Media;
use Omega\Library\Util\LinkChooser;
?>
<div class="row">
    <?php for($i = 0; $i < 3; $i++) : ?>
        <?php
        $title = 'title'.$i;
        $text = 'text'.$i;
        $image = 'image'.$i;
        $icon = 'icon'.$i;

        ?>
    <section class="4u align-center">
        <?php if(!$use_image) : ?>
            <span class="fa-stack fa-5x">
            <i class="fa fa-circle fa-stack-2x"></i>
            <i class="fa <?php echo $$icon ?>  fa-stack-1x fa-inverse"></i>
        </span>
        <?php else : ?>
            <?php
            $media0 = new Media($$image);
            ?>
            <div class="service-logo" style="background-image: url('<?php echo $media0->path ?>')">
            </div>
        <?php endif ?>
        <h3><?php echo $$title ?></h3>
        <p><?php echo $$text ?></p>
    </section>
    <?php endfor ?>
</div>
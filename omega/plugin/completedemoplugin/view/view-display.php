<?php

use Omega\Library\Entity\Media;
use Omega\Library\Entity\VideoExternal;
use Omega\Library\Entity\Page;

?>

    <h2>View from plugin</h2>
    <p>Text : <?php echo $text ?></p>
    <p>Rich Text : <?php echo $richtext ?></p>
    <p>Radio Button chosen : <?php echo $radiobutt['title'] ?></p>

<?php foreach ($mediachoo as $ms) : ?>
    <?php
    $media = new Media($ms['id']);
    ?>
    <?php if ($media->getType() == Media::T_VIDEO_EXT) : ?>

        <?php
        $media = new VideoExternal($ms['id'], true);
        ?>
        <p>Media Choosen : <br/> <iframe width="560" height="315" src="https://youtube.com/embed/<?php echo $media->getVideoId() ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe> </p>

    <?php endif; ?>
<?php endforeach; ?>

    <p><i class="fa <?php echo $iconchoo ?>"></i> <a href="<?php echo $linkchoo ?>"><?php echo $linkchoo ?></a></p>

    <div class="row"><div class="col-sm-offset-<?php echo $dropdownhc['value'] ?>"><?php echo $dropdownhc['title'] ?></div></div>

<?php $page = new Page($dropdownmodel['value']) ?>
    <div class="well">
        <?php $page->render() ?>
        <?php echo $page->content ?>
    </div>

    <p> Option 1 : <?php echo $checkboxhc['opt1'] ?> </p>
    <p> Option 2 : <?php echo $checkboxhc['opt2'] ?> </p>

<?php foreach ($checkboxmodel as $idpage => $value) : ?>

    <?php if ($value) : ?>
        <?php $page = new Page($idpage) ?>
        <div class="well">
            <?php $page->render() ?>
            <?php echo $page->content ?>
        </div>
    <?php endif; ?>
<?php endforeach; ?>



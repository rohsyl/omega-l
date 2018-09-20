<?php
    use Omega\Library\Entity\Media;


    $parallax_enable = $parallax['parallax'];
?>
<?php if(isset($picture)) : ?>
    <?php if(isset($parallax_enable) && $parallax_enable): ?>
        <div class="parallax-window"
             style="min-height: <?php echo isset($parallax_height) ? $parallax_height : 400 ?>px"
             data-parallax="scroll"
             data-image-src="<?php echo $picture->path ?>"></div>
    <?php else : ?>
       <div class="image-container">
           <img src="<?php echo $picture->path ?>" alt="<?php echo $picture->name ?>" />
       </div>
    <?php endif ?>
<?php endif ?>
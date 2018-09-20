<div class="plugin plugin-sociallogo">
    <h3 style="margin-bottom : 10px;"><?php echo $title ?></h3>
    <?php foreach($socialNetworks as $key => $sn) : ?>
        <?php if(isset($moduleParam[$key])) : ?>
            <a class="logo <?php echo $key ?>" title="<?php echo $sn['name'] ?>" target="_blank" href="<?php echo $moduleParam[$key] ?>"><span class="<?php echo $sn['class'] ?>"></span></a>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
<style>
    <?php foreach($socialNetworks as $key => $sn) : ?>
    <?php if(isset($moduleParam[$key])) : ?>
        .plugin-sociallogo .logo.<?php echo $key ?> {
            background-color : <?php echo $sn['color'] ?>;
            transition: 0.3s all ease-in 0s;
        }
        .plugin-sociallogo .logo.<?php echo $key ?>:hover {
            background-color : <?php echo $sn['colorHover'] ?>;
        }
    <?php endif; ?>
    <?php endforeach; ?>
</style>

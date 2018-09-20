<div class="list-group">
    <?php foreach($entities as $entity) : ?>
        <button type="button" class="list-group-item entity-item" data-id="<?php echo $entity->id ?>"><i class="fa fa-database"></i> <?php echo $entity->title ?></button>
    <?php endforeach; ?>
</div>
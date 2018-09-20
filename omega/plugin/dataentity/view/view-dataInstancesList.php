
<div class="list-group">
    <?php foreach($dataList as $data) : ?>
    <button type="button" class="list-group-item entity-item-data" data-id="<?php echo $data['id'] ?>" data-entity-title="<?php echo $entity->title ?>">
        <i class="fa fa-cube"></i>
        <span class="title">
            <?php echo implode(', ', $data['data']) ?>
        </span>
    </button>
<?php endforeach; ?>
</div>
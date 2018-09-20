<select class="form-control" id="entity-views">
    <?php foreach ($views as $view) : ?>
        <option value="<?php echo $view->id ?>" <?php echo $idView == $view->id ? 'selected' : '' ?>><?php echo $view->name ?></option>
    <?php endforeach; ?>
</select>

<?php echo $this->partialView('menu') ?>
<ol class="breadcrumb">
    <li><a href="<?= $this->getAdminLink('index') ?>">Sections</a></li>
    <li><?php e(${SEC_NAME_S}) ?></li>
</ol>
<table class="table">
    <tr>
        <th>Name</th>
        <th>Year</th>
        <th>
            <a class="btn btn-xs btn-primary" href="<?php echo $this->getAdminLink('addAlbum', array('id' => ${SEC_ID})) ?>">Add album</a>
        </th>
    </tr>
    <?php foreach($albums as $album) : ?>
        <tr>
            <td><?php echo $album[ALB_NAME] ?></td>
            <td><?php echo date('Y', strtotime($album[ALB_YEAR])) ?></td>
            <td>
                <a href="<?php echo $this->getAdminLink('images', array('id' => $album[ALB_ID])) ?>">Images</a> |
                <a href="<?php echo $this->getAdminLink('editAlbum', array('id' => $album[ALB_ID], 'secid' => ${SEC_ID})) ?>">Edit</a> |
                <a href="#" data-url="<?php echo $this->getAdminLink('deleteAlbum', array('id' => $album[ALB_ID], 'secid' => ${SEC_ID})) ?>" class="delete">Delete</a>
            </td>
        </tr>
    <?php endforeach ?>
    <?php if(sizeof($albums) == 0) : ?>
        <tr>
            <td colspan="4" class="text-center">
                There is no album. <a href="<?php echo $this->getAdminLink('addAlbum') ?>" class="btn btn-primary btn-xs">Add new</a>
            </td>
        </tr>

    <?php endif ?>
</table>


<?php echo $this->partialView('menu') ?>
<ol class="breadcrumb">
    <li><a href="<?= $this->getAdminLink('index') ?>">Sections</a></li>
    <li><?php echo $category[SEC_NAME_S]?></li>
</ol>
<table class="table">
    <tr>
        <th>Name</th>
        <th>Date</th>
        <th>
        </th>
    </tr>
    <?php foreach($items as $item) : ?>
        <tr>
            <td><?php echo $item[ALB_NAME] ?></td>
            <td><?php echo $item[ALB_YEAR] ?></td>
            <td>
                <a href="<?php echo $this->getAdminLink('editItem', array('id' => $item[ALB_ID])) ?>">Edit</a> |
                <a href="#" data-url="<?php echo $this->getAdminLink('deleteItem', array('id' => $item[ALB_ID])) ?>" class="delete">Delete</a>
            </td>
        </tr>
    <?php endforeach ?>
    <?php if(sizeof($item) == 0) : ?>
        <tr>
            <td colspan="4" class="text-center">
                There is no item. <a href="<?php echo $this->getAdminLink('addItem') ?>" class="btn btn-primary btn-xs">Add new</a>
            </td>
        </tr>

    <?php endif ?>
</table>


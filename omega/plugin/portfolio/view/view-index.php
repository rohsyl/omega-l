<?php echo $this->partialView('menu') ?>
<table class="table">
    <tr>
        <th>Name</th>
        <th>Category</th>
        <th>Date</th>
        <th></th>
    </tr>
    <?php foreach($items as $item) : ?>
        <tr>
            <td><?php echo $item->name ?></td>
            <td><?php echo $item->category->name ?></td>
            <td><?php echo $item->dateItem ?></td>
            <td>
                <a href="<?php echo $this->getAdminLink('editItem', array('id' =>$item->id)) ?>">Edit</a> |
                <a href="#" data-url="<?php echo $this->getAdminLink('deleteItem', array('id' =>$item->id)) ?>" class="delete">Delete</a>
            </td>
        </tr>
    <?php endforeach ?>
    <?php if(sizeof($items) == 0) : ?>
        <tr>
            <td colspan="4" class="text-center">
                There is no items. <a href="<?php echo $this->getAdminLink('addItem') ?>" class="btn btn-primary btn-xs">Add new</a>
            </td>
        </tr>

    <?php endif ?>
</table>


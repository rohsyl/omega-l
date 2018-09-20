<?php echo $this->partialView('menu') ?>
<table class="table">
    <tr>
        <th>Name</th>
        <th></th>
    </tr>
    <?php foreach($categories as $item) : ?>
        <tr>
            <td>
                <span class="color-block" style="background-color: <?php echo $item->color ?>"></span>
                <?php echo $item->name ?>
            </td>
            <td>
                <a href="<?php echo $this->getAdminLink('editCategory', array('id' =>$item->id)) ?>">Edit</a> |
                <a href="#" data-url="<?php echo $this->getAdminLink('deleteCategory', array('id' =>$item->id)) ?>" class="delete">Delete</a>
            </td>
        </tr>
    <?php endforeach ?>
    <?php if(sizeof($categories) == 0) : ?>
        <tr>
            <td colspan="4" class="text-center">
                There is no category. <a href="<?php echo $this->getAdminLink('addCategory') ?>" class="btn btn-primary btn-xs">Add new</a>
            </td>
        </tr>

    <?php endif ?>
</table>
<style>
    .color-block
    {
        width : 10px;
        height : 10px;
        border-radius: 100%;
        display : inline-block;
    }
</style>

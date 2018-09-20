<?php echo $this->partialView('menu') ?>
<ol class="breadcrumb">
    <li>Sections</li>
</ol>
<table class="table">
    <tr>
        <th>Name</th>
        <th>Description</th>
        <th>
            <a class="btn btn-xs btn-primary" href="<?php echo $this->getAdminLink('addSection') ?>">Add section</a>
        </th>
    </tr>
    <?php foreach($sections as $section) : ?>
        <tr>
            <td><?php echo $section[SEC_NAME_S] ?></td>
            <td><?php echo $section[SEC_DESCR] ?></td>
            <td>
                <a href="<?php echo $this->getAdminLink('albums', array('id' => $section[SEC_ID])) ?>">Albums</a> |
                <a href="<?php echo $this->getAdminLink('editSection', array('id' => $section[SEC_ID])) ?>">Edit</a> |
                <a href="#" data-url="<?php echo $this->getAdminLink('deleteSection', array('id' => $section[SEC_ID])) ?>" class="delete">Delete</a>
            </td>
        </tr>
    <?php endforeach ?>
    <?php if(sizeof($sections) == 0) : ?>
        <tr>
            <td colspan="4" class="text-center">
                There is no section. <a href="<?php echo $this->getAdminLink('addSection') ?>" class="btn btn-primary btn-xs">Add new</a>
            </td>
        </tr>

    <?php endif ?>
</table>


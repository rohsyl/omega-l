<?php $action = $this->getAdminLink('customProperties'); ?>

<table class="table">
    <tr>
        <th>
            Name
        </th>
        <th>
            Action
        </th>
    </tr>
<?php foreach ($properties as $property) : ?>
    <tr>
        <td>
            <input type="text" value="<?php echo $property->title ?>" class="form-control" name="cpTitles[<?php echo $property->id ?>]" />
        </td>
        <td>
            <a href="<?php echo $action ?>&cp=delete&pid=<?php echo $property->id ?>" class="btn btn-danger">Delete</a>
        </td>
    </tr>
<?php endforeach; ?>
</table>
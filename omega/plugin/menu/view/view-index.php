<?php
use Omega\Library\Plugin\BController;
?>
<?php echo $this->partialView('menu') ?>
<table class="table">
	<tr>
		<th>ID</th>
		<th>Name</th>
		<th>Actions</th>
	</tr>
<?php if($listElement->length() == 0) { ?>
	<tr>
		<td colspan="3" align="center">No menu element. <a href="<?= BController::staticGetAdminLink($this->name, 'add') ?>" class="btn btn-sm btn-primary">Add new</a></td>
	</tr>
<?php } else { ?>

	<?php for($i = 0; $i < $listElement->length(); $i++) { ?>
	<tr>
		<td><?= $listElement->getInt($i, 'id') ?></td>
		<td><?= $listElement->getString($i, 'moduleName') ?></td>
		<td>
			<span class="action">
				<a href="<?= BController::staticGetAdminLink($this->name, 'edit', array('id' => $listElement->getInt($i, 'id'))) ?>">Edit</a>
				<a href="<?= BController::staticGetAdminLink($this->name, 'delete', array('id' => $listElement->getInt($i, 'id'))) ?>">Delete</a>
			</span>
		</td>
	</tr>
	<?php } ?>
	
<?php } ?>
</table>
<?php
use Omega\Library\Plugin\BController;
?>
<?php echo $this->partialView('menu') ?>
<table class="table">
	<tr>
		<th>Name</th>
		<th></th>
	</tr>
	<?php foreach($categories as $p) { ?>
	<tr>
		<td><?php echo $p->name ?></td>
		<td>
            <span class="action-img-page-list">
				<a href="<?php echo $this->getAdminLink('editcategory', array('id' => $p->id)) ?>"><span class="glyphicon glyphicon-pencil"></span></a>
				<a href="<?php echo $this->getAdminLink('deletecategory', array('id' => $p->id)) ?>" data-url="<?php echo $this->getAdminLink('deletecategory', array('id' => $p->id)) ?>" class="delete"><span class="glyphicon glyphicon-trash"></span></a>
			</span>
		</td>
	</tr>
	<?php } ?>
</table>
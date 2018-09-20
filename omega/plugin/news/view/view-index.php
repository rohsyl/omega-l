<?php
use Omega\Library\Plugin\BController;
?>
<?php echo $this->partialView('menu') ?>
<table class="table">
	<tr>
		<th>Titre</th>
		<th>Date</th>
        <th>Catégories</th>
		<th></th>
	</tr>
	<?php foreach($posts as $p) { ?>
	<tr>
		<td><?php echo $p->title ?></td>
		<td><?php echo date('Y-m-d', strtotime($p->created)) ?></td>
        <td>
            <?php
                $i = 0;
                $size = sizeof($p->categories);
                foreach($p->categories as $c) {
                    echo $c->name;

                    if($i < $size - 1)
                        echo ', ';
                    $i++;
                }
            ?>
        </td>
		<td>
            <span class="action-img-page-list">
				<a href="<?php echo $this->getAdminLink('edit', array('id' => $p->id)) ?>"><span class="glyphicon glyphicon-pencil"></span></a>
				<a href="<?php echo $this->getAdminLink('delete', array('id' => $p->id)) ?>" data-url="<?php echo $this->getAdminLink('delete', array('id' => $p->id)) ?>" class="delete"><span class="glyphicon glyphicon-trash"></span></a>
			</span>
		</td>
	</tr>
	<?php } ?>
</table>
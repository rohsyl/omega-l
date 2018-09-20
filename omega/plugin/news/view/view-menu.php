<?php 
	$action = $_GET['action'];
?>
<br />
<ul class="nav nav-pills">
	<li <?php if($action == 'index') { ?> class="active" <?php } ?>>
		<a href="<?= $this->getAdminLink('index') ?>"><span class="glyphicon glyphicon-list"></span> Articles</a>
	</li>
    <li <?php if($action == 'add') { ?> class="active" <?php } ?>>
        <a href="<?= $this->getAdminLink('add') ?>"><span class="glyphicon glyphicon-plus"></span> Ajouter un article</a>
    </li>
	<li <?php if($action == 'categories') { ?> class="active" <?php } ?>>
		<a href="<?= $this->getAdminLink('categories') ?>"><span class="glyphicon glyphicon-list"></span> Catégories</a>
	</li>
    <li <?php if($action == 'addcategory') { ?> class="active" <?php } ?>>
        <a href="<?= $this->getAdminLink('addcategory') ?>"><span class="glyphicon glyphicon-plus"></span> Ajouter une catégorie</a>
    </li>
</ul>
<hr />
<br />
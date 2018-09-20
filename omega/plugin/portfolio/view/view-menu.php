<?php
$action = $_GET['action'];
?>
<ul class="nav nav-pills">
    <li <?php if($action == 'index') { ?> class="active" <?php } ?>>
        <a href="<?= $this->getAdminLink('index') ?>"><span class="glyphicon glyphicon-list"></span> List</a>
    </li>
    <li <?php if($action == 'addItem') { ?> class="active" <?php } ?>>
        <a href="<?= $this->getAdminLink('addItem') ?>"><span class="glyphicon glyphicon-plus"></span> Add item</a>
    </li>
    <li <?php if($action == 'categories') { ?> class="active" <?php } ?>>
        <a href="<?= $this->getAdminLink('categories') ?>"><span class="glyphicon glyphicon-list"></span> Categories</a>
    </li>
    <li <?php if($action == 'addCategory') { ?> class="active" <?php } ?>>
        <a href="<?= $this->getAdminLink('addCategory') ?>"><span class="glyphicon glyphicon-plus"></span> Add category</a>
    </li>
    <li <?php if($action == 'settings') { ?> class="active" <?php } ?>>
        <a href="<?= $this->getAdminLink('settings') ?>"><span class="glyphicon glyphicon-cog"></span> Settings</a>
    </li>
    <li <?php if($action == 'customProperties') { ?> class="active" <?php } ?>>
        <a href="<?= $this->getAdminLink('customProperties') ?>"><span class="glyphicon glyphicon-align-justify"></span> Custom Properties</a>
    </li>
</ul>
<hr />
<br />

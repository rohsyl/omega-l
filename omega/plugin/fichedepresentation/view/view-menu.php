<?php
$action = $_GET['action'];
?>
<br />
<ul class="nav nav-pills">
    <li <?php if($action == 'index') { ?> class="active" <?php } ?>>
        <a href="<?= $this->getAdminLink('index') ?>"><span class="glyphicon glyphicon-list"></span> Liste des articles locales</a>
    </li>
    <li <?php if($action == 'getArticlesFromDatabase') { ?> class="active" <?php } ?>>
        <a href="<?= $this->getAdminLink('getArticlesFromDatabase') ?>"><span class="fa fa-cog"></span> Récupérer les articles depuis la base de données Nocturne</a>
    </li>
</ul>
<hr />
<br />
<style>
    .input-first{
        border-radius : 3px 3px 0px 0px;
        margin-bottom : -1px;
        z-index : 9;
    }
    .input-last{
        border-radius : 0px 0px 3px 3px;
        z-index : 9;
    }
    .input-first:focus, .input-last:focus{
        z-index : 10;
    }
</style>
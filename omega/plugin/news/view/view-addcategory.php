
<?php echo $this->partialView('menu') ?>
<?php
$action = $this->getAdminLink('addcategory');
?>

<form class="form-horizontal" action="<?php echo $action ?>" method="POST">

    <!-- Text input-->
    <div class="form-group">
        <label class="col-md-4 control-label" for="name">Catégorie</label>
        <div class="col-md-4">
            <input id="name" name="name" type="text" placeholder="Catégorie" class="form-control input-md">

        </div>
    </div>

    <!-- Button -->
    <div class="form-group">
        <label class="col-md-4 control-label" for="addCategory"></label>
        <div class="col-md-4">
            <button id="addCategory" name="addCategory" class="btn btn-primary">Ajouter</button>
        </div>
    </div>

</form>

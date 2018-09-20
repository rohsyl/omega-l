
<?php echo $this->partialView('menu') ?>
<?php
$action = $this->getAdminLink('editcategory', array('id' => $category->id));
?>

<form class="form-horizontal" action="<?php echo $action ?>" method="POST">

    <!-- Text input-->
    <div class="form-group">
        <label class="col-md-4 control-label" for="name">Catégorie</label>
        <div class="col-md-4">
            <input id="name" name="name" value="<?php echo $category->name ?>" type="text" placeholder="Catégorie" class="form-control input-md">

        </div>
    </div>

    <!-- Button -->
    <div class="form-group">
        <label class="col-md-4 control-label" for="editCategory"></label>
        <div class="col-md-4">
            <button id="editCategory" name="editCategory" class="btn btn-primary">Sauvegarder</button>
        </div>
    </div>

</form>

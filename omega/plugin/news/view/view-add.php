<?php echo $this->partialView('menu') ?>
<?php
$action = $this->getAdminLink('add');
?>
<form class="form-horizontal" action="<?php echo $action ?>" method="POST">

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="title">Titre de la news :</label>  
  <div class="col-md-4">
  <input id="title" name="title" placeholder="Titre" class="form-control input-md" type="text">
    
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="btnAdd"></label>
  <div class="col-md-4">
    <button id="btnAdd" name="btnAdd" class="btn btn-primary btn-block">Créer</button>
  </div>
</div>
</form>

<?php echo $this->partialView('menu');
$action = $this->getAdminLink('addCategory');
?>

<form class="form-horizontal" method="post" action="<?php echo $action ?>">

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="name">Name</label>  
  <div class="col-md-4">
  <input id="name" name="name" placeholder="Name" class="form-control input-md" type="text">
  <span class="help-block">The name of the category</span>  
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="btnAddCategory"></label>
  <div class="col-md-4">
    <button id="btnAddCategory" name="btnAddCategory" class="btn btn-primary" type="submit">Save</button>
  </div>
</div>
</form>

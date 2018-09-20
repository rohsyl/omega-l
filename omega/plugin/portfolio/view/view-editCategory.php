<?php echo $this->partialView('menu');
$action = $this->getAdminLink('editCategory', array('id' => $_GET['id']));
?>

<form class="form-horizontal" method="post" action="<?php echo $action ?>">

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="name">Name</label>  
  <div class="col-md-4">
  <input id="name" name="name" placeholder="Name" class="form-control input-md" type="text" value="<?php echo $item->name ?>">
  <span class="help-block">The name of the category</span>  
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="color">Color</label>  
  <div class="col-md-4">
  <input id="color" name="color" placeholder="gray" class="form-control input-md" type="text" value="<?php echo $item->color ?>">
    
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="btnSaveCat"></label>
  <div class="col-md-4">
    <button id="btnSaveCat" name="btnSaveCat" class="btn btn-primary">Save</button>
  </div>
</div>
</form>


<!-- 
css : css/colorpicker/css/bootstrap-colorpicker.min.css
js :  css/colorpicker/js/bootstrap-colorpicker.js
-->


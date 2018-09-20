<?php
    use Omega\Library\Util\Form;

?>
<?php echo $this->partialView('menu') ?>
<form class="form-horizontal" action="<?php echo $this->getAdminLink('add') ?>" method="POST" >
  <?php Form::getTokenInput('addElement') ?>
  <!-- Text input-->
  <div class="form-group">
    <label class="col-md-4 control-label" for="title">Title :</label>
    <div class="col-md-4">
    <input id="title" name="title" type="text" placeholder="Title" class="form-control input-md">

    </div>
  </div>

  <!-- Select Basic -->
  <div class="form-group">
    <label class="col-md-4 control-label" for="idMenu">Menu :</label>
    <div class="col-md-4">
      <select id="idMenu" name="idMenu" class="form-control">
          <?php for($i = 0; $i < $listMenu->length(); $i++) { ?>
              <option value="<?php echo $listMenu->getInt($i, 'id') ?>"><?php echo $listMenu->getString($i, 'menuName') ?></option>
          <?php } ?>
      </select>
    </div>
  </div>

  <!-- Text input-->
  <div class="form-group">
    <label class="col-md-4 control-label" for="beforeTitle">Before title :</label>
    <div class="col-md-4">
    <input id="beforeTitle" name="beforeTitle" type="text" placeholder="<h4>" class="form-control input-md">

    </div>
  </div>

  <!-- Text input-->
  <div class="form-group">
    <label class="col-md-4 control-label" for="afterTitle">After title :</label>
    <div class="col-md-4">
    <input id="afterTitle" name="afterTitle" type="text" placeholder="</h4>" class="form-control input-md">

    </div>
  </div>

  <!-- Multiple Checkboxes (inline) -->
  <div class="form-group">
    <label class="col-md-4 control-label" for="displayTitle">Display title :</label>
    <div class="col-md-4">
      <label class="checkbox-inline" for="displayTitle-0">
        <input type="checkbox" name="displayTitle" id="displayTitle-0" value="1">
        Yes
      </label>
    </div>
  </div>

  <!-- Text input-->
  <div class="form-group">
    <label class="col-md-4 control-label" for="beforeContent">Before content :</label>
    <div class="col-md-4">
    <input id="beforeContent" name="beforeContent" type="text" placeholder="" class="form-control input-md">

    </div>
  </div>

  <!-- Text input-->
  <div class="form-group">
    <label class="col-md-4 control-label" for="afterContent">After content :</label>
    <div class="col-md-4">
    <input id="afterContent" name="afterContent" type="text" placeholder="" class="form-control input-md">

    </div>
  </div>

  <!-- Multiple Checkboxes (inline) -->
  <div class="form-group">
    <label class="col-md-4 control-label" for="isVertical">Is vertical :</label>
    <div class="col-md-4">
      <label class="checkbox-inline" for="isVertical-0">
        <input type="checkbox" name="isVertical" id="isVertical-0" value="1">
        Yes
      </label>
    </div>
  </div>

  <!-- Text input-->
  <div class="form-group">
    <label class="col-md-4 control-label" for="divClass">Module div class :</label>
    <div class="col-md-4">
    <input id="divClass" name="divClass" type="text" placeholder="<h4>" class="form-control input-md">

    </div>
  </div>
  
  <!-- Text input-->
  <div class="form-group">
    <label class="col-md-4 control-label" for="ulClass">UL class :</label>
    <div class="col-md-4">
    <input id="ulClass" name="ulClass" type="text" placeholder="" class="form-control input-md">

    </div>
  </div>

  <!-- Text input-->
  <div class="form-group">
    <label class="col-md-4 control-label" for="liClass">LI class :</label>
    <div class="col-md-4">
    <input id="liClass" name="liClass" type="text" placeholder="" class="form-control input-md">

    </div>
  </div>

  <!-- Button -->
  <div class="form-group">
    <label class="col-md-4 control-label" for="submit"></label>
    <div class="col-md-4">
      <button id="submit" name="addElement" class="btn btn-primary btn-block">Add</button>
    </div>
  </div>
</form>

<?php
    $url = $this->getAdminLink('addEntity');
?>
<form class="form-horizontal" method="post" action="<?php echo $url ?>">

    <!-- Text input-->
    <div class="form-group">
        <label class="col-md-4 control-label" for="entityName">Entity Name :</label>
        <div class="col-md-4">
            <input id="entityName" name="entityName" type="text" placeholder="Entity Name" class="form-control input-md">
            <span class="help-block">The name of the entity</span>
        </div>
    </div>

    <!-- Button -->
    <div class="form-group">
        <label class="col-md-4 control-label" for="addEntity"></label>
        <div class="col-md-4">
            <button id="addEntity" name="addEntity" class="btn btn-primary">Create Entity</button>
        </div>
    </div>
</form>

<?php echo $this->partialView('menu') ?>
<ol class="breadcrumb">
    <li><a href="<?= $this->getAdminLink('index') ?>">Sections</a></li>
    <li>Add</li>
</ol>
<form class="form-horizontal" action="<?php echo $this->getAdminLink('addSection'); ?>" method="post">

    <!-- Text input-->
    <div class="form-group">
        <label class="col-md-4 control-label" for="name_simple">Name</label>
        <div class="col-md-4">
            <input id="name_simple" name="<?php echo SEC_NAME_S ?>" placeholder="Name" class="form-control input-md" type="text">

        </div>
    </div>

    <!-- Button -->
    <div class="form-group">
        <label class="col-md-4 control-label" for="saveNewSection"></label>
        <div class="col-md-4">
            <button id="saveNewSection" name="saveNewSection" class="btn btn-primary" type="submit">Save</button>
        </div>
    </div>

</form>

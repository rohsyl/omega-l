


<br />
<ol class="breadcrumb">
    <li><a href="<?php echo $this->getAdminLink('index') ?>"><i class="fa fa-home"></i> Data Entity</a></li>
    <li><a href="<?php echo $this->getAdminLink('layout') ?>"><i class="fa fa-object-group"></i> Layouts</a></li>
    <li><i class="fa fa-plus"></i> Add Layout</li>
</ol>


<?php
$url = $this->getAdminLink('addLayout');
?>
<form class="form-horizontal" method="post" action="<?php echo $url ?>">


    <!-- Text input-->
    <div class="form-group">
        <label class="col-md-4 control-label" for="layoutName">Layout Name :</label>
        <div class="col-md-4">
            <input id="layoutName" name="layoutName" type="text" placeholder="Layout Name" class="form-control input-md">
            <span class="help-block">The name of the layout</span>
        </div>
    </div>


    <!-- Button -->
    <div class="form-group">
        <label class="col-md-4 control-label" for="addLayout"></label>
        <div class="col-md-4">
            <button id="addLayout" name="addLayout" class="btn btn-primary">Create Layout</button>
        </div>
    </div>
</form>

<?php echo $this->partialView('menu') ?>
<ol class="breadcrumb">
    <li><a href="<?= $this->getAdminLink('index') ?>">Sections</a></li>
    <li><a href="<?php echo $this->getAdminLink('albums', array('id' => ${SEC_ID})) ?>"><?php e(${SEC_NAME_S}) ?></a></li>
    <li>Add album</li>
</ol>
<h4>Add album</h4>
<hr />
<form class="form-horizontal" action="<?php echo $this->getAdminLink('addAlbum', array('id' => ${SEC_ID})); ?>" method="post">

    <!-- Text input-->
    <div class="form-group">
        <label class="col-md-4 control-label" for="name">Name</label>
        <div class="col-md-4">
            <input id="name" name="<?php echo ALB_NAME ?>" placeholder="Name" class="form-control input-md" type="text">

        </div>
    </div>

    <!-- Text input-->
    <div class="form-group">
        <label class="col-md-4 control-label" for="date">Date</label>
        <div class="col-md-4">
            <input id="date" name="<?php echo ALB_YEAR ?>" class="form-control " type="text" />
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            $('#date').datepicker({
                format: 'yyyy-mm-dd'
            });
        });
    </script>

    <!-- Button -->
    <div class="form-group">
        <label class="col-md-4 control-label" for="saveNewAlbum"></label>
        <div class="col-md-4">
            <button id="saveNewAlbum" name="saveNewAlbum" class="btn btn-primary" type="submit">Save</button>
        </div>
    </div>

</form>

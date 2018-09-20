<?php echo $this->partialView('menu') ?>
<ol class="breadcrumb">
    <li><a href="<?= $this->getAdminLink('index') ?>">Sections</a></li>
    <li><a href="<?php echo $this->getAdminLink('albums', array('id' => $section[SEC_ID])) ?>"><?php echo $section[SEC_NAME_S] ?></a></li>
    <li>Edit album : <?php echo $album[ALB_NAME] ?></li>
</ol>
<h4>Edit album : <?php echo $album[ALB_NAME] ?></h4>
<hr />
<form class="form-horizontal" action="<?php echo $this->getAdminLink('editAlbum', array('id' => $album[ALB_ID], 'secid' => $section[SEC_ID])); ?>" method="post">

    <!-- Text input-->
    <div class="form-group">
        <label class="col-md-4 control-label" for="name">Name</label>
        <div class="col-md-4">
            <input value="<?php echo $album[ALB_NAME] ?>" id="name" name="<?php echo ALB_NAME ?>" placeholder="Name" class="form-control input-md" type="text">
        </div>
    </div>

    <!-- Text input-->
    <div class="form-group">
        <label class="col-md-4 control-label" for="date">Date</label>
        <div class="col-md-4">
            <input value="<?php echo date('Y-m-d', strtotime($album[ALB_YEAR])) ?>"  id="date" name="<?php echo ALB_YEAR ?>" class="form-control " type="text" />
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
            <button id="saveAlbum" name="saveAlbum" class="btn btn-primary" type="submit">Save</button>
        </div>
    </div>

</form>

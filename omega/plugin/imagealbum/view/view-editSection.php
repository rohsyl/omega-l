<?php
use Omega\Library\Entity\Media;
?>
<?php echo $this->partialView('menu') ?>
<ol class="breadcrumb">
    <li><a href="<?= $this->getAdminLink('index') ?>">Sections</a></li>
    <li>Edit</li>
</ol>
<form class="form-horizontal" action="<?php echo $this->getAdminLink('editSection', array('id' => $id)); ?>" method="post">

    <!-- Text input-->
    <div class="form-group">
        <label class="col-md-4 control-label" for="name_simple">Simple name</label>
        <div class="col-md-4">
            <input value="<?php echo e(${SEC_NAME_S}) ?>" id="name_simple" name="<?php echo SEC_NAME_S ?>" placeholder="Simple name" class="form-control input-md" type="text">

        </div>
    </div>

    <!-- Text input-->
    <div class="form-group">
        <label class="col-md-4 control-label" for="name_full">Full name</label>
        <div class="col-md-4">
            <input value="<?php echo e(${SEC_NAME_F}) ?>" id="name_full" name="<?php echo SEC_NAME_F ?>" placeholder="Full name" class="form-control input-md" type="text">

        </div>
    </div>

    <!-- Text input-->
    <div class="form-group">
        <label class="col-md-4 control-label" for="descr">Description</label>
        <div class="col-md-4">
            <input value="<?php echo e(${SEC_DESCR}) ?>" id="descr" name="<?php echo SEC_DESCR ?>" placeholder="Description" class="form-control input-md" type="text">

        </div>
    </div>


    <div class="form-group">
        <label class="col-md-4 control-label" for="image">Image</label>
        <div class="col-md-4"><?php
            $media = new Media(${SEC_IMG});
            $name = $media->name;
            $id = $media->id;
            ?>
            <div class="input-group">
                <input value="<?php echo $name ?>" id="image-name" placeholder="Image" class="form-control input-md" type="text">
                <input value="<?php echo $id ?>" id="image" name="<?php echo SEC_IMG ?>" type="hidden">
                <span id="mediaChooserImage" class="input-group-addon btn btn-primary">Choisir</span>
            </div>
        </div>
    </div>


    <!-- Button -->
    <div class="form-group">
        <label class="col-md-4 control-label" for="saveNewSection"></label>
        <div class="col-md-4">
            <button id="saveSection" name="saveSection" class="btn btn-primary" type="submit">Save</button>
        </div>
    </div>

</form>

<script>
    $(function() {
        $('#mediaChooserImage').rsMediaChooser({
            multiple: false,
            allowedMedia: [
                'picture'
            ],
            doneFunction: function (data) {
                $('#image').val(data.id);
                $('#image-name').val(data.name);
            }
        });
    });
</script>

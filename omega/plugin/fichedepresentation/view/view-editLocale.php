<?php echo $this->partialView('menu') ?>
<?php
use Omega\Library\Entity\Media;

$action = $this->getAdminLink('editLocale', array('id' => $article->id));

?>

<form class="form-horizontal" method="post" action="<?php echo $action ?>">
    <!-- Text input-->
    <div class="form-group">
        <label class="control-label" for="ref">Ref</label>
        <input id="ref" name="ref" placeholder="Ref" class="form-control input-md readonly" readonly type="text" value="<?php echo $article->ref ?>">
    </div>
    <!-- Text input-->
    <div class="form-group">
        <label class="control-label" for="name">Name</label>
        <input id="name" name="name" placeholder="Name" class="form-control input-md" type="text" value="<?php echo $article->name ?>">
    </div>

    <!-- Appended Input-->
    <div class="form-group">
        <label class="control-label" for="imageName">Image</label>
        <div class="input-group">
            <?php
            $media = new Media($article->fkMediaImage);

            $name = $media->name;
            $id = $media->id;
            ?>
            <input value="<?php echo $name ?>" id="imageName" name="imageName" placeholder="Image" class="form-control input-md" type="text">
            <input value="<?php echo $id ?>" id="imageId" name="image" type="hidden">
            <span id="mediaChooseImage" class="input-group-addon btn btn-primary">Choisir</span>
        </div>
    </div>

    <!-- Appended Input-->
    <div class="form-group">
        <label class="control-label" for="presName">Presentation</label>
        <div class="input-group">
            <?php
            $media = new Media($article->fkMediaPres);

            $name = $media->name;
            $id = $media->id;
            ?>
            <input value="<?php echo $name ?>" id="presName" name="presName" placeholder="Presentation" class="form-control input-md" type="text">
            <input value="<?php echo $id ?>" id="presId" name="pres" type="hidden">
            <span id="mediaChoosePres" class="input-group-addon btn btn-primary">Choisir</span>
        </div>
    </div>

    <!-- Appended Input-->
    <div class="form-group">
        <label class="control-label" for="panelName">Panel</label>
        <div class="input-group">
            <?php
            $media = new Media($article->fkMediaPanel);

            $name = $media->name;
            $id = $media->id;
            ?>
            <input value="<?php echo $name ?>" id="panelName" name="panelName" placeholder="Panel" class="form-control input-md" type="text">
            <input value="<?php echo $id ?>" id="panelId" name="panel" type="hidden">
            <span id="mediaChoosePanel" class="input-group-addon btn btn-primary">Choisir</span>
        </div>
    </div>

    <!-- Button -->
    <div class="form-group">
        <button id="btnSave" name="saveLocaleArticle" class="btn btn-primary">Save</button>
    </div>
</form>
<script>
    $(function() {
        $('#mediaChooseImage').rsMediaChooser({
            multiple: false,
            allowedMedia: [
                'picture'
            ],
            doneFunction: function (data) {
                $('#imageId').val(data.id);
                $('#imageName').val(data.name);
            }
        });
        $('#mediaChoosePres').rsMediaChooser({
            multiple: false,
            allowedMedia: [
                'document'
            ],
            doneFunction: function (data) {
                $('#presId').val(data.id);
                $('#presName').val(data.name);
            }
        });
        $('#mediaChoosePanel').rsMediaChooser({
            multiple: false,
            allowedMedia: [
                'document'
            ],
            doneFunction: function (data) {
                $('#panelId').val(data.id);
                $('#panelName').val(data.name);
            }
        });
    });
</script>

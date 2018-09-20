<?php
use Omega\Library\Entity\Media;
?>
<h2>Settings</h2>
<form action="<?php echo $this->getAdminLink('settings') ?>" method="POST">
    <div class="row">
        <div class="col-sm-6">
            <h3>Size of image :</h3>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label" for="big_image_width">Width</label>
                        <div class="input-group">
                            <input value="<?php echo $config['big_image_width'] ?>" type="text" class="form-control" name="big_image_width" id="big_image_width" />
                            <span class="input-group-addon">px</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label" for="big_image_height">Height</label>
                        <div class="input-group">
                            <input value="<?php echo $config['big_image_height'] ?>" type="text" class="form-control" name="big_image_height" id="big_image_height" />
                            <span class="input-group-addon">px</span>
                        </div>
                    </div>
                </div>
            </div>


            <h3>Copyright image :</h3>
            <div class="checkbox">
                <label>
                    <input <?php echo $config['copyright_enable'] ? 'checked' : '' ?> type="checkbox" name="copyright_enable" id="copyright_enable"> Display copyright
                </label>
            </div>
            <div class="form-group">
                <label class="control-label" for="copyright_image_name">Copyright image</label>
                <div class="input-group">
                    <?php
                    $id = isset($config['copyright_image']) ? $config['copyright_image'] : null;
                    $media = new Media($id);

                    $name = $media->name;
                    $id = $media->id;
                    ?>
                    <input value="<?php echo $name ?>" id="copyright_image_name" placeholder="Picture" class="form-control input-md" type="text">
                    <input value="<?php echo $id ?>" id="copyright_image" name="copyright_image" type="hidden">
                    <span id="copyright_image_chooser" class="input-group-addon btn btn-primary">Choisir</span>
                </div>
            </div>

            <h3>Size of thumbnail :</h3>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label" for="thumbnail_width">Width</label>
                        <div class="input-group">
                            <input value="<?php echo $config['thumbnail_width'] ?>" type="text" class="form-control" name="thumbnail_width" id="thumbnail_width" />
                            <span class="input-group-addon">px</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label" for="thumbnail_height">Height</label>
                        <div class="input-group">
                            <input value="<?php echo $config['thumbnail_height'] ?>" type="text" class="form-control" name="thumbnail_height" id="thumbnail_height" />
                            <span class="input-group-addon">px</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary" name="btnSaveSettingsImageAlbum">Save</button>
    <a href="<?php echo $this->getAdminLink('previewCopyright') ?>" class="btn btn-default">Preview</a>
</form>


<script>
    $(function() {
        $('#copyright_image_chooser').rsMediaChooser({
            multiple: false,
            allowedMedia: [
                'picture'
            ],
            doneFunction: function (data) {
                $('#copyright_image').val(data.id);
                $('#copyright_image_name').val(data.name);
            }
        });
    });
</script>
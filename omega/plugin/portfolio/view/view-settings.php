<?php
echo $this->partialView('menu');
$action = $this->getAdminLink('settings');
?>
<form class="form-horizontal" method="post" action="<?php echo $action ?>">
    <div class="form-group">
        <label class="col-md-4 control-label" for="image-zoom">Image Zoom</label>
        <div class="col-md-4">
            <div class="checkbox">
                <label for="image-zoom-0">
                    <input type="checkbox" name="image-zoom" id="image-zoom-0" value="1" <?php echo $settings['image-zoom'] ? 'checked' : '' ?> />
                    Add a "+" on item slider to zoom on image
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-4 control-label" for="owl-nav">Display slider nav controls</label>
        <div class="col-md-4">
            <div class="checkbox">
                <label for="owl-nav-0">
                    <input type="checkbox" name="owl-nav" id="owl-nav-0" value="1" <?php echo $settings['owl-nav'] ? 'checked' : '' ?> />
                    Display "next" and "previous" button on the image slider
                </label>
            </div>
        </div>
    </div>

    <!-- Button -->
    <div class="form-group">
        <label class="col-md-4 control-label" for="btnSavePortfolioSettings"></label>
        <div class="col-md-4">
            <button id="btnSavePortfolioSettings" name="btnSavePortfolioSettings" class="btn btn-primary">Save</button>
        </div>
    </div>

</form>
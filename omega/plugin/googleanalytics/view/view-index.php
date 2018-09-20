<?php
use Omega\Library\Util\Form;
?>
<br />
<?php
$current_action_link = $this->getAdminLink('index');
?>
<form class="form-horizontal" method="POST" action="<?php echo $current_action_link ?>">

    <?php Form::getTokenInput("googleanalytics_form") ?>

    <div class="form-group">
        <div class="col-md-4 col-md-offset-4">
            <div class="alert alert-info">
                <strong><i class="fa fa-info-circle"></i> Information</strong>
                    You must <a href="<?php echo $this->getAdminLink('help') ?>" class="alert-link">place the google analytics module</a> in a module area to enable tracking.
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label" for="enabledAnalytics">Enable</label>
        <div class="col-md-4">
            <label class="checkbox-inline" for="enabledAnalytics-0">
                <input type="checkbox" name="enabledAnalytics" id="enabledAnalytics-0" value="1" <?php echo $enabledAnalytics ? 'checked' : '' ?>>
                Yes
            </label>
            <div class="help-block">
                Check this to enable Google Analytics Tracking
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label" for="id">Tracking ID</label>
        <div class="col-md-4">
            <input value="<?php echo $id ?>" id="id" name="id" placeholder="Id" class="form-control input-md" type="text">
            <div class="help-block">
                Google Analytics Tracking ID (looks like UA-xxxxxxxx-x)
            </div>
        </div>
    </div>

    <br />
    <!-- Button -->
    <div class="form-group">
        <div class="col-md-4 col-md-offset-4">
            <input type="submit" name="googleanalytics_form" value="Save" class="btn btn-block btn-primary"/>
        </div>
    </div>
</form>

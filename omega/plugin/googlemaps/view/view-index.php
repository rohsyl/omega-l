<?php
use Omega\Library\Util\Form;
?>
<br />
<?php
$current_action_link = $this->getAdminLink('index');
?>

<form class="form-horizontal" method="POST" action="<?php echo $current_action_link ?>">

    <?php Form::getTokenInput("googlemaps_form") ?>

    <div class="form-group">
        <div class="col-md-4 col-md-offset-4">
            <div class="alert alert-info">
                <strong><i class="fa fa-info-circle"></i> Information</strong>
                    You must <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" class="alert-link">get an API Key</a> and set it down here.
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label" for="apikey">API Key</label>
        <div class="col-md-4">
            <input value="<?php echo $apikey ?>" id="apikey" name="apikey" placeholder="API Key" class="form-control input-md" type="text">
            <div class="help-block">
                Google Maps JS API Key
            </div>
        </div>
    </div>


    <div class="form-group">
        <label class="col-md-4 control-label" for="mapstyle">Map style</label>
        <div class="col-md-4">
            <textarea id="mapstyle" name="mapstyle" placeholder="Map style" class="form-control" rows="18"><?php echo $mapstyle ?></textarea>
            <div class="help-block">
                Google Maps Style as JSON. You can use <a href="https://mapstyle.withgoogle.com/" target="_blank">this tool</a> to create map style.
            </div>
        </div>
    </div>

    <br />
    <!-- Button -->
    <div class="form-group">
        <div class="col-md-4 col-md-offset-4">
            <input type="submit" name="googlemaps_form" value="Save" class="btn btn-block btn-primary"/>
        </div>
    </div>
</form>
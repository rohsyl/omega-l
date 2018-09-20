<?php
use Omega\Library\Util\Form;

$current_action_link = $this->getAdminLink('index');
?>

<form class="form-horizontal" method="POST" action="<?php echo $current_action_link ?>">

    <?php Form::getTokenInput('facebookfeed_form'); ?>

    <div class="form-group">
        <div class="col-md-4 col-md-offset-4">
            <div class="alert alert-info">
                <strong><i class="fa fa-info-circle"></i> Information</strong>
                You must <a href="https://developers.facebook.com/" class="alert-link">get an API Key</a> and set it down here.
            </div>
        </div>
    </div>
    <!-- Text input-->
    <div class="form-group">
        <label class="col-md-4 control-label" for="fbapikey">API Key</label>
        <div class="col-md-5">
            <input id="fbapikey" name="fbapikey" type="text" placeholder="86ef05c080d5dfebd7f028b196824e5a" class="form-control input-md" value="<?php echo $apikey ?>">
            <span class="help-block">Your Facebook API Key</span>
        </div>
    </div>

    <!-- Button -->
    <div class="form-group">
        <label class="col-md-4 control-label" for="btnsavefbapikey"></label>
        <div class="col-md-4">
            <button id="btnsavefbapikey" name="facebookfeed_form" class="btn btn-primary">Save</button>
        </div>
    </div>

</form>

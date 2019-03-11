<?php
use Omega\Library\Util\MessageFront;
use Omega\Library\Util\Util;
use Omega\Library\PMvc\PController;
use Omega\Library\PMvc\PView;
use Omega\Library\Util\Form;
use function Omega\Library\oo;

if(isset($customClass))
{
    $tabs = $customClass->getTabs();
}
else
{
    $tabs = null;
}

if(!isset($_GET['tab'])) $_GET['tab'] = $currentTab;
?>
<div class="member-profil">
<?php MessageFront::displayAll(); ?>
<!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="<?php echo isActiv('info') ?>"><a href="#info" aria-controls="info" role="tab" data-toggle="tab"><?php oo('Informations') ?></a></li>
        <li role="presentation" class="<?php echo isActiv('passwd') ?>"><a href="#passwd" aria-controls="passwd" role="tab" data-toggle="tab"><?php oo('Change password') ?></a></li>
        <?php if(isset($tabs)) : foreach($tabs as $t) : ?>
        <?php $key = Util::toTextKey($t['action']) ?>
        <li role="presentation" class="<?php echo isActiv($key) ?>"><a href="#<?php echo $key ?>" aria-controls="passwd" role="tab" data-toggle="tab"><?php echo $t['title'] ?></a></li>
        <?php endforeach; endif ?>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane <?php echo isActiv('info') ?>" id="info">
            <div class="profil-info-data">
                <p><strong><?php oo('Pseudo') ?> </strong><?php echo $member->pseudo; ?></p>
                <p><strong><?php oo('Mail') ?> </strong><?php echo $member->mail; ?></p>
            </div>
            <?php if(isset($hasCustomInfo) && $hasCustomInfo) : ?>
                <?php echo $customInfo ?>
            <?php endif ?>
        </div>
        <div role="tabpanel" class="tab-pane <?php echo isActiv('passwd') ?>" id="passwd">
            <br />
            <form action="<?php echo PController::Url('member', 'profil') ?>" method="POST">
            <?php Form::getTokenInput('formChangePassword'); ?>

            <!-- Password input-->
                <div class="form-group">
                    <label class="control-label" for="oldpasswd"><?php oo('Old password') ?> :</label>
                    <input id="oldpasswd" name="oldpasswd" class="form-control input-md" type="password">
                </div>

                <!-- Password input-->
                <div class="form-group">
                    <label class="control-label" for="password1"><?php oo('New password twice') ?> :</label>
                    <input id="password1" name="password1" class="form-control input-md" type="password">
                </div>

                <!-- Password input-->
                <div class="form-group">
                    <input id="password2" name="password2" class="form-control input-md" type="password">
                </div>

                <!-- Button (Double) -->
                <div class="form-group">
                    <button id="formChangePassword" name="formChangePassword" type="submit" class="btn btn-primary btn-block"><?php oo('Save') ?></button>
                </div>
            </form>

        </div>
        <?php if(isset($tabs)) : foreach($tabs as $t) : ?>
        <?php $key = Util::toTextKey($t['action']) ?>
        <div role="tabpanel" class="tab-pane <?php echo isActiv($key) ?>" id="<?php echo $key ?>">
            <?php
            $customClass->currentAction = $t['action'];
            $customClass->view = new PView($customClass->currentController, $customClass->currentAction);
            echo $customClass->$t['action']() ?>
        </div>
        <?php endforeach; endif?>
    </div>

</div>


<?php
function isActiv($tab) {
    global $currentTab;
    if(isset($_GET['tab']) && !empty($_GET['tab'])) {
        return $_GET['tab'] == $tab ? 'active' : '';
    }
    else {
        return $currentTab == $tab ? 'active' : '';
    }
}
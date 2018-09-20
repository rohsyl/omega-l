<?php
use Omega\Library\Util\Form;
?>
<br />
<?php
$current_action_link = $this->getAdminLink('index');
?>
<form class="form-horizontal" method="POST" action="<?php echo $current_action_link ?>">
    <?php Form::getTokenInput("social_logo") ?>
    <div class="form-group">
        <label class="col-md-4 control-label" for="title">Title</label>
        <div class="col-md-4">
            <input value="<?php echo $title ?>" id="title" name="title" placeholder="Title" class="form-control input-md" type="text">
        </div>
    </div><br />
    <?php foreach($socialNetworks as $key => $sn) : ?>
        <div class="form-group">
            <label class="col-md-4 control-label" for="<?php echo $key ?>"><?php echo $sn['name'] ?></label>
            <div class="col-md-4">
                <?php
                    $value = isset($moduleParam[$key]) ? $moduleParam[$key] : '';
                ?>
                <input value="<?php echo $value ?>" id="<?php echo $key ?>" name="<?php echo $key ?>" placeholder="<?php echo $sn['name'] ?>" class="form-control input-md" type="text">
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Button -->
    <div class="form-group">
        <div class="col-md-4 col-md-offset-4">
            <input type="submit" name="social_logo" value="Save" class="btn btn-block btn-primary"/>
        </div>
    </div>
</form>

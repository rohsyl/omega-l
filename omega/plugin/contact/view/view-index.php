<?php

use Omega\Library\Util\Url;
use Omega\Library\Util\Form;
use Omega\Library\Entity\Media;
use function Omega\Library\__;

?>
<script>
    $(function () {
        $('#mediaChooser').rsMediaChooser({
            multiple: false,
            allowedMedia: [
                'picture'
            ],
            doneFunction: function (data) {
                $('#logo').val(data.id);
                $('#image-name').val(data.name);
            }
        });

        $('#tabs-contact a').click(function (e) {
            e.preventDefault()
            $(this).tab('show')
        })
    });
</script>

<?php
$current_action_link = $this->getAdminLink('index');
?>
<form class="form-horizontal" action="<?php echo $current_action_link ?>" method="POST">
    <?php Form::getTokenInput("contactForm") ?>


    <div>

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" id="tabs-contact" role="tablist">
            <li role="presentation" class="active"><a href="#info" aria-controls="info" role="tab" data-toggle="tab">Informations</a>
            </li>
            <li role="presentation"><a href="#tab-mail" aria-controls="tab-mail" role="tab" data-toggle="tab">Contact form</a>
            </li>
        </ul>

        <br/>
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="info">


                <div class="form-group">
                    <label class="control-label col-md-4" for="logo"><?php __('Contact logo') ?></label>
                    <div class="col-md-4">
                        <div class="input-group">
                            <?php
                            $logo = isset($paramData['contactLogo']) ? $paramData['contactLogo'] : null;
                            $media = new Media($logo);

                            $name = $media->name;
                            $id = $media->id;
                            ?>
                            <input value="<?php echo $name ?>" id="image-name" name="image-name" placeholder="Logo"
                                   class="form-control input-md" type="text">
                            <input value="<?php echo $id ?>" id="logo" name="logo" type="hidden">
                            <span id="mediaChooser" class="input-group-addon btn btn-primary">Choose</span>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-4">
                        <div class="checkbox">
                            <label>
                                <?php $checked = isset($paramData['displayLogo']) && $paramData['displayLogo'] ? 'checked' : '' ?>
                                <input type="checkbox" <?php echo $checked ?> name="displayLogo"> <?php __('Display the logo') ?>
                            </label>
                        </div>

                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="phone"><?php __('Phone') ?></label>
                    <div class="col-md-4">
                        <input value="<?php echo isset($paramData['phone']) ? $paramData['phone'] : '' ?>" id="phone"
                               name="phone" placeholder="Phone" class="form-control input-md" type="text">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="mobile"><?php __('Mobile') ?></label>
                    <div class="col-md-4">
                        <input value="<?php echo isset($paramData['mobile']) ? $paramData['mobile'] : '' ?>" id="mobile"
                               name="mobile" placeholder="Mobile" class="form-control input-md" type="text">

                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="fax"><?php __('Fax') ?></label>
                    <div class="col-md-4">
                        <input value="<?php echo isset($paramData['fax']) ? $paramData['fax'] : '' ?>" id="fax"
                               name="fax" placeholder="Fax" class="form-control input-md" type="text">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="mail_info"><?php __('Mail') ?></label>
                    <div class="col-md-4">
                        <input value="<?php echo isset($paramData['mail_info']) ? $paramData['mail_info'] : '' ?>" id="mail_info"
                               name="mail_info" placeholder="Mail" class="form-control input-md" type="text">
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-4 control-label" for="name"><?php __('Name') ?></label>
                    <div class="col-md-4">
                        <input value="<?php echo isset($paramData['name']) ? $paramData['name'] : '' ?>" id="name"
                               name="name" placeholder="Name" class="form-control input-md" type="text">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="street"><?php __('Street') ?></label>
                    <div class="col-md-4">
                        <input value="<?php echo isset($paramData['street']) ? $paramData['street'] : '' ?>" id="street"
                               name="street" placeholder="Street" class="form-control input-md" type="text">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="npa"><?php __('NPA / Locality') ?></label>
                    <div class="col-md-4">
                        <input value="<?php echo isset($paramData['npa']) ? $paramData['npa'] : '' ?>" id="npa"
                               name="npa" placeholder="NPA" class="form-control input-md" type="text">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="locality"></label>
                    <div class="col-md-4">
                        <input value="<?php echo isset($paramData['locality']) ? $paramData['locality'] : '' ?>"
                               id="locality" name="locality" placeholder="Locality" class="form-control input-md"
                               type="text">
                    </div>
                </div>


            </div>


            <div role="tabpanel" class="tab-pane" id="tab-mail">



                <div class="form-group">
                    <label class="col-md-4 control-label" for="mail"><?php __('Mail') ?></label>
                    <div class="col-md-4">
                        <input value="<?php echo isset($paramData['mail']) ? $paramData['mail'] : '' ?>" id="mail"
                               name="mail" placeholder="Mail" class="form-control input-md" type="text">
                        <div class="help-block">
                            <?php __('Message sent with the contact form will be send to this mail address') ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="conf_message"><?php __('Confirmation message') ?></label>
                    <div class="col-md-4">
                        <textarea class="form-control" id="conf_message" name="conf_message"><?php echo isset($paramData['conf_message']) ? $paramData['conf_message'] : '' ?></textarea>
                        <div class="help-block">
                            <?php __('Message displayed to the user after he have submitted his message') ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-4">
                        <div class="checkbox">
                            <label>
                                <?php $checked = isset($paramData['is_antispam']) && $paramData['is_antispam'] ? 'checked' : '' ?>
                                <input type="checkbox" <?php echo $checked ?> name="is_antispam"> <?php __('Enable Antispam') ?>
                            </label>
                        </div>

                    </div>
                </div>

            </div>


        </div>

    </div>

    <!-- Button -->
    <div class="form-group">
        <label class="col-md-4 control-label" for="contactForm"></label>
        <div class="col-md-4">
            <button id="contactForm" name="contactForm" type="submit"
                    class="btn btn-primary"><?php __('Save') ?></button>
        </div>
    </div>

</form>







<div class="om-wrapper">
    <div class="member-profil">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">

            <li role="presentation" class="nav-item active"><a href="#info" class="nav-link" aria-controls="info" role="tab" data-toggle="tab">{{ __('Informations') }}</a></li>
            <li role="presentation" class="nav-item"><a href="#passwd" class="nav-link" aria-controls="passwd" role="tab" data-toggle="tab">{{ __('Change password') }}</a></li>

            <!--{{-- <?php if(isset($tabs)) : foreach($tabs as $t) : ?>
            <?php $key = Util::toTextKey($t['action']) ?>
            <li role="presentation" class="<?php echo isActiv($key) ?>"><a href="#<?php echo $key ?>" aria-controls="passwd" role="tab" data-toggle="tab"><?php echo $t['title'] ?></a></li>
            <?php endforeach; endif ?> --}}-->
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="info">
                <div class="row">
                    <div class="col-md-3">
                        <div class="avatar-container">
                            <span class="avatar-text">{{ strtoupper(substr($member->username, 0, 1)) }}</span>
                        </div>
                    </div>
                    <div class="col">
                        <dl>
                            <dt>{{ __('Username') }}</dt>
                            <dd>{{ $member->username }}</dd>

                            <dt>{{ __('E-mail') }}</dt>
                            <dd>{{ $member->email }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane " id="passwd">
                <br />

                <form action="" method="POST">

                <!-- Password input-->
                    <div class="form-group">
                        <label class="control-label" for="oldpasswd">{{ __('Old password') }} :</label>
                        <input id="oldpasswd" name="oldpasswd" class="form-control input-md" type="password">
                    </div>

                    <!-- Password input-->
                    <div class="form-group">
                        <label class="control-label" for="password1">{{ __('New password twice') }} :</label>
                        <input id="password1" name="password1" class="form-control input-md" type="password">
                    </div>

                    <!-- Password input-->
                    <div class="form-group">
                        <input id="password2" name="password2" class="form-control input-md" type="password">
                    </div>

                    <!-- Button (Double) -->
                    <div class="form-group">
                        <button id="formChangePassword" name="formChangePassword" type="submit" class="btn btn-primary btn-block">{{ __('Save') }}</button>
                    </div>
                </form>

            </div>
            <!--{{--
            <?php if(isset($tabs)) : foreach($tabs as $t) : ?>
            <?php $key = Util::toTextKey($t['action']) ?>
            <div role="tabpanel" class="tab-pane <?php echo isActiv($key) ?>" id="<?php echo $key ?>">
                <?php
                $customClass->currentAction = $t['action'];
                $customClass->view = new PView($customClass->currentController, $customClass->currentAction);
                echo $customClass->$t['action']() ?>
            </div>
            <?php endforeach; endif?>
            --}}-->
        </div>

    </div>
</div>

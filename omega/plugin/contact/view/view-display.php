<div class="plugin plugin-contact">
    <?php if(isset($messageType)) : ?>
        <div class="alert alert-<?php echo $messageType ?>">
            <?php echo isset($message) ? $message : '' ?>
        </div>
    <?php endif; ?>
    <form action="" method="POST" class="form">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <input class="form-control" value="<?php echo isset($_POST['name']) ? $_POST['name'] : '' ?>" type="text" name="name" placeholder="Nom"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <input class="form-control" value="<?php echo isset($_POST['mail']) ? $_POST['mail'] : '' ?>" type="text" name="mail" placeholder="E-mail"/>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <input class="form-control" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : '' ?>" type="text" name="phone" placeholder="Téléphone"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div>Message :</div>
                <div class="form-group">
                    <textarea class="form-control" name="message"><?php echo isset($_POST['message']) ? $_POST['message'] : '' ?></textarea>
                </div>
            </div>
        </div>
        <?php if($isAntispam) : ?>
        <div class="row">
            <div class="col-md-6">
                <div>Captcha: <br /><img src="<?php echo $_SESSION['captcha']['image_src'] ?>" /></div>
                <div class="form-group">
                    <input  type="text" name="result" class="form-control">
                </div>
            </div>
        </div>
        <?php endif ?>
        <p class="text-right">
            <input type="submit" name="contactForm" class="btn btn-primary" value="Envoyer"/>
        </p>
    </form>
</div>
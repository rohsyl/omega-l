<div class="plugin plugin-contact">
    <form action="" method="POST" name="sentMessage">
        <?php if(isset($messageType)) : ?>
            <div class="alert alert-<?php echo $messageType ?>">
                <?php echo isset($message) ? $message : '' ?>
            </div>
        <?php endif; ?>
        <div class="control-group">
            <div class="form-group floating-label-form-group controls">
                <label>Nom</label>
                <input type="text" class="form-control" placeholder="Nom" name="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : '' ?>">
                <p class="help-block text-danger"></p>
            </div>
        </div>
        <div class="control-group">
            <div class="form-group floating-label-form-group controls">
                <label>Adresse mail</label>
                <input type="email" class="form-control" placeholder="Adresse mail" name="mail" value="<?php echo isset($_POST['mail']) ? $_POST['mail'] : '' ?>">
                <p class="help-block text-danger"></p>
            </div>
        </div>
        <div class="control-group">
            <div class="form-group floating-label-form-group controls">
                <label>Numéro de téléphone</label>
                <input type="tel" class="form-control" placeholder="Numéro de téléphone" name="phone" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : '' ?>">
                <p class="help-block text-danger"></p>
            </div>
        </div>
        <div class="control-group">
            <div class="form-group floating-label-form-group controls">
                <label>Message</label>
                <textarea rows="5" class="form-control" placeholder="Message" name="message" ><?php echo isset($_POST['message']) ? $_POST['message'] : '' ?></textarea>
                <p class="help-block text-danger"></p>
            </div>
        </div>
        <?php if($isAntispam) : ?>
        <div class="control-group">

            <div class="form-group floating-label-form-group controls">
                <label>Captcha</label>
                <input type="text" name="result" placeholder="Captcha"  class="form-control">
            </div>
            <div><br /><img src="<?php echo $_SESSION['captcha']['image_src'] ?>" /></div>
        </div>
        <?php endif ?>
        <br>
        <div id="success"></div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary" id="sendMessageButton" name="contactForm">Envoyer</button>
        </div>
    </form>
</div>
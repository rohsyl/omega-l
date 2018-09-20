<?php
use Omega\Library\Entity\Media;
?>


<?php if($param['displayLogo'] && isset($param['contactLogo'])): ?>
    <div class="contact-contactlogo">
        <?php
        $media = new Media($param['contactLogo']);

        ?>
        <img src="<?php echo $media->path ?>" alt="<?php echo $media->title ?>"/>
    </div>
<?php endif ?>


<address class="contact-contactadress">
    <i class="fa fa-map-marker"></i><br/>
    <strong><?php echo $param['name'] ?></strong><br>
    <?php echo $param['street'] ?><br>
    <?php echo $param['locality'] ?>, <?php echo $param['npa'] ?><br>
</address>


<address class="contact-contactinfo">
    <div class="center-icon mail">
        <i class="fa fa-envelope"></i>
    </div>
    <a href="mailto:<?php echo $param['mail_info'] ?>"><?php echo $param['mail_info'] ?></a><br />
    <?php if(!empty($param['phone'])) : ?>
        <div class="center-icon phone">
            <i class="fa fa-phone"></i>
        </div>
        <?php echo $param['phone'] ?><br />
    <?php endif; ?>
    <?php if(!empty($param['mobile'])) : ?>
        <div class="center-icon mobile">
            <i class="fa fa-mobile"></i>
        </div>
        <?php echo $param['mobile'] ?><br />
    <?php endif; ?>
    <?php if(!empty($param['fax'])) : ?>
         <div class="center-icon fax">
            <i class="fa fa-fax"></i>
         </div>
        <?php echo $param['fax'] ?>
    <?php endif; ?>
</address>

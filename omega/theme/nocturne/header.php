<?php
use Omega\Library\Entity\Entity;
use Omega\Library\Util\OmegaUtil;
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title><?php echo Entity::Site()->name ?> <?php echo Entity::Site()->slogan ?> - <?php echo Entity::Page()->title ?></title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <?php OmegaUtil::renderMeta() ?>

        <!-- Theme Stylesheet -->
        <link rel="stylesheet" href="<?php echo Entity::Site()->template_directory_uri ?>/assets/css/main.css" />
        <link rel="stylesheet" href="<?php echo Entity::Site()->template_directory_uri ?>/css/style.css" />
        <link rel="stylesheet" href="<?php echo Entity::Site()->template_directory_uri ?>/assets/css/font-awesome.min.css">


        <!-- Theme javascript -->
        <script src="<?php echo Entity::Site()->template_directory_uri ?>/assets/js/jquery.min.js"></script>
        <script src="<?php echo Entity::Site()->template_directory_uri ?>/assets/js/jquery.scrolly.min.js"></script>
        <script src="<?php echo Entity::Site()->template_directory_uri ?>/assets/js/skel.min.js"></script>
        <script src="<?php echo Entity::Site()->template_directory_uri ?>/assets/js/util.js"></script>
        <script src="<?php echo Entity::Site()->template_directory_uri ?>/assets/js/main.js"></script>

        <!-- Theme special stylesheet -->
        <?php Entity::Page()->RenderCssTheme() ?>

        <!-- Plugin assets -->
        <?php OmegaUtil::renderDependencies() ?>
    </head>
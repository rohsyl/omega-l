<?php
use Omega\Library\Util\OmegaUtil;
use Omega\Library\Entity\Entity;

?>


<!DOCTYPE HTML>
<!--
	Industrious by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html>
<head>
    <title><?php echo Entity::Site()->name ?> - <?php echo Entity::Page()->title ?></title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <?php OmegaUtil::renderMeta() ?>

    <!-- CSS -->
    <link rel="stylesheet" href="<?= Entity::Site()->template_directory_uri ?>/vendor/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo Entity::Site()->template_directory_uri ?>/assets/css/main.css" />
    <link rel="stylesheet" href="<?php echo Entity::Site()->template_directory_uri ?>/css/styles.css" />

    <!-- JS -->
    <script src="<?= Entity::Site()->template_directory_uri ?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?= Entity::Site()->template_directory_uri ?>/vendor/bootstrap/js/bootstrap.min.js"></script>


    <?php Entity::Page()->RenderCssTheme() ?>
    <?php OmegaUtil::renderDependencies() ?>
</head>
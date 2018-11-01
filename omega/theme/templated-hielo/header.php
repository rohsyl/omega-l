<?php
use Omega\Utils\OmegaUtils;
use Omega\Utils\Entity\Entity;
?>
<!DOCTYPE HTML>
<!--
	Hielo by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html>
<head>

    <title><?php echo Entity::Site()->name ?> - <?php echo Entity::Page()->title ?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php OmegaUtils::renderMeta() ?>
    <link rel="stylesheet" href="<?= Entity::Site()->template_directory_uri ?>/assets/css/main.css" />

    <!-- Scripts -->
    <script src="<?= Entity::Site()->template_directory_uri ?>/assets/js/jquery.min.js"></script>
    <script src="<?= Entity::Site()->template_directory_uri ?>/assets/js/jquery.scrollex.min.js"></script>
    <script src="<?= Entity::Site()->template_directory_uri ?>/assets/js/skel.min.js"></script>
    <script src="<?= Entity::Site()->template_directory_uri ?>/assets/js/util.js"></script>
    <script src="<?= Entity::Site()->template_directory_uri ?>/assets/js/main.js"></script>

    <?php Entity::Page()->RenderCssTheme() ?>
    <?php OmegaUtils::renderDependencies() ?>
</head>
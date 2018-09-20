<?php
    use Omega\Library\Util\OmegaUtil;
    use Omega\Library\Entity\Entity;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php OmegaUtil::renderMeta() ?>

    <title><?php echo Entity::Site()->name ?> - <?php echo Entity::Page()->title ?></title>

    <link href="<?= Entity::Site()->template_directory_uri ?>/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Theme CSS -->
    <link href="<?= Entity::Site()->template_directory_uri ?>/css/styles.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="<?= Entity::Site()->template_directory_uri ?>/vendor/jquery/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?= Entity::Site()->template_directory_uri ?>/vendor/bootstrap/js/bootstrap.min.js"></script>
    <!-- Contact Form JavaScript -->
    <!-- Theme JavaScript -->
    <script src="<?= Entity::Site()->template_directory_uri ?>/js/scripts.js"></script>

    <!-- Theme Glyphicons -->
    <script src="<?= Entity::Site()->template_directory_uri ?>/vendor/bootstrap/fonts/glyphicons-halflings-regular.svg"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    -->

    <?php Entity::Page()->RenderCssTheme() ?>
    <?php OmegaUtil::renderDependencies() ?>
</head>
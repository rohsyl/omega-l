<?php
    use Omega\Library\Util\OmegaUtil;
    use Omega\Library\Entity\Entity;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php OmegaUtil::renderMeta() ?>

    <title><?php echo Entity::Site()->name ?> - <?php echo Entity::Page()->title ?></title>

    <!-- Bootstrap Core CSS -->
    <link href="<?= Entity::Site()->template_directory_uri ?>/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Theme CSS -->
    <link href="<?= Entity::Site()->template_directory_uri ?>/css/clean-blog.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    <!-- jQuery -->
    <script src="<?= Entity::Site()->template_directory_uri ?>/vendor/jquery/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?= Entity::Site()->template_directory_uri ?>/vendor/bootstrap/js/bootstrap.min.js"></script>
    <!-- Contact Form JavaScript -->
    <script src="<?= Entity::Site()->template_directory_uri ?>/js/jqBootstrapValidation.js"></script>
    <script src="<?= Entity::Site()->template_directory_uri ?>/js/contact_me.js"></script>
    <!-- Theme JavaScript -->
    <script src="<?= Entity::Site()->template_directory_uri ?>/js/clean-blog.min.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <?php Entity::Page()->RenderCssTheme() ?>
    <?php OmegaUtil::renderDependencies() ?>
</head>
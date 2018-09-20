<?php
use Omega\Library\Util\OmegaUtil;
use Omega\Library\Entity\Entity;
use Omega\Library\Util\Url;
?>
<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php OmegaUtil::renderMeta() ?>
    <title><?php echo Entity::Site()->name ?> - <?php echo Entity::Page()->title ?></title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo Url::CombAndAbs(ABSPATH, 'assets/css/bootstrap.min.css') ?>">
    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Poppins:400,300,500,600,700' rel='stylesheet' type='text/css'>
    <!-- Font Awesome -->
    <link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css' rel='stylesheet' type='text/css'>
    <!-- Style -->
    <link href='<?= Entity::Site()->template_directory_uri ?>/style.css' rel='stylesheet' type='text/css'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery -->
    <script src="//code.jquery.com/jquery.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="<?php echo Url::CombAndAbs(ABSPATH, 'assets/js/bootstrap.min.js') ?>"></script>

    <?php Entity::Page()->RenderCssTheme() ?>
    <?php OmegaUtil::renderDependencies() ?>

</head>
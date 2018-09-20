<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $site->name ?> - <?php echo $page->title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <?php OmegaUtil::renderMeta() ?>



    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $site->template_directory_uri ?>/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="<?php echo $site->template_directory_uri ?>/favicons/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="<?php echo $site->template_directory_uri ?>/favicons/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="<?php echo $site->template_directory_uri ?>/favicons/manifest.json">
    <link rel="mask-icon" href="<?php echo $site->template_directory_uri ?>/favicons/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">



    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900|Quicksand:400,700|Questrial" rel="stylesheet" />
    <link href="<?php echo $site->template_directory_uri ?>/css/bootstrap.min.css" rel="stylesheet" />
    <?php $page->RenderCssTheme() ?>
    <?php OmegaUtil::renderDependencies() ?>
    <link href="<?php echo $site->template_directory_uri ?>/css/fonts.css" rel="stylesheet" type="text/css" media="all" />
    <link href="<?php echo $site->template_directory_uri ?>/css/default.css" rel="stylesheet" type="text/css" media="all" />
    <link href="<?php echo $site->template_directory_uri ?>/css/jquery.mmenu.all.css" rel="stylesheet" type="text/css" media="all" />


    <script src="<?php echo $site->template_directory_uri ?>/js/jquery-2.0.3.min.js"></script>
    <script src="<?php echo $site->template_directory_uri ?>/js/jquery.mobile.touch.min.js"></script>
    <script src="<?php echo $site->template_directory_uri ?>/js/bootstrap.min.js"></script>
    <script src="<?php echo $site->template_directory_uri ?>/js/jquery.mmenu.all.min.js"></script>
    <script src="<?php echo $site->template_directory_uri ?>/js/main.js"></script>
    <!--[if lte IE 8]><script src="<?php echo $site->template_directory_uri ?>/js/html5shiv.js"></script><![endif]-->




    <script type="text/javascript">
        $(document).ready(function() {
            $(window).resize(function(){
                displayMobileMenu();
            });
            displayMobileMenu();
            function displayMobileMenu() {
                if ($(window).width() < 992) {
                    $("#menu-mobile").mmenu({
                        slidingSubmenus: false
                    });
                }
            }
        });
    </script><script>
        $(document).ready(function() {
            $(".carousel").swiperight(function() {
                $(".carousel").carousel('prev');
            });
            $(".carousel").swipeleft(function() {
                $(".carousel").carousel('next');
            });
        });
    </script>
</head>
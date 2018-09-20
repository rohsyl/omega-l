<?php
    use Omega\Library\Entity\Entity;
?>
<body>
<div class="container">
    <!-- Page Header -->
    <nav class="navbar navbar-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="/">
                    <img alt="Brand" src="<?php echo Entity::Site()->template_directory_uri?>/img/Yvon_Mab_CMYK_rect_white.svg" style="height: 50px;">
                </a>
            </div>

            <div class="navbar-right hidden-xs hidden-sm">
                <a class="navbar-brand navbar-brand-left" href="/">
                    <img alt="Brand" src="<?php echo Entity::Site()->template_directory_uri?>/img/Personnages_Vehicule_white.svg" style="height: 50px;">
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <?php echo Entity::Page()->content ?>
</div>
<!-- Navigation -->
<nav class="navbar navbar-default navbar-custom navbar-fixed-bottom">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <?php include(Entity::Site()->php_template_path . '/menu.php'); ?>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
<?php include('footer.php'); ?>
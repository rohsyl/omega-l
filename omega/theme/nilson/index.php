<body>
<div id="header-wrapper">
    <a href="#menu-mobile" class="menu-mobile-toggle hidden-md hidden-lg"><i class="fa fa-bars"></i></a>
    <div id="header" class="container">
        <div id="logo">
            <a href="<?php echo UrlHelper::Absolute(ABSPATH) ?>">
                <img src="<?php echo $site->template_directory_uri ?>/images/logo.svg" alt="<?php echo $site->name ?>" />
            </a>
        </div>
        <nav id="menu" class="hidden-sm hidden-xs">
            <?php echo $menu->getBySecurity(); ?>
        </nav>
    </div>
</div>
<div class="wrapper-x">
    <div class="container">
        <?php echo $page->content ?>
    </div>
</div>
<nav id="menu-mobile" class="hidden-md hidden-lg">
    <?php echo $menu->getBySecurity(); ?>
</nav>
<?php include('footer.php'); ?>
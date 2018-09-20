<?php
use Omega\Library\Entity\Entity;

include(Entity::Site()->php_template_path . DS . 'function.php');
?>
<body class="is-preload">

<!-- Header -->
<header id="header">
    <a class="logo" href="<?php echo ABSPATH ?>"><?php echo Entity::Site()->name ?></a>
    <nav>
        <a href="#menu">Menu</a>
    </nav>
</header>

<!-- Nav -->
<nav id="menu">
    <?php echo Entity::Menu()->getBySecurity(); ?>
</nav>

<!-- Banner -->
<section id="banner">
    <div class="inner">
        <h1><?php echo Entity::Site()->name ?></h1>
        <p><?php echo Entity::Site()->slogan ?></p>
    </div>
    <video autoplay loop muted playsinline src="<?php echo Entity::Site()->template_directory_uri ?>/images/banner.mp4"></video>
</section>


<?php echo Entity::Page()->content ?>


<?php include(Entity::Site()->php_template_path . DS . 'footer.php'); ?>

<?php
use Omega\Library\Entity\Entity;

include(Entity::Site()->php_template_path . DS . 'function.php');
?>
<body class="is-preload has-container">

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

<!-- Heading -->
<div id="heading" >
    <h1><?php echo Entity::Page()->title ?></h1>
</div>

<section id="main" class="wrapper">
    <div class="inner">
        <div class="content">
            <?php echo Entity::Page()->content ?>
        </div>
    </div>
</section>


<?php include(Entity::Site()->php_template_path . DS . 'footer.php'); ?>

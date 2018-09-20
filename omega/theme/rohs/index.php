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

<!-- Heading -->
<div id="heading" >
    <h1><?php echo Entity::Page()->title ?></h1>
</div>

<?php echo Entity::Page()->content ?>


<?php include(Entity::Site()->php_template_path . DS . 'footer.php'); ?>

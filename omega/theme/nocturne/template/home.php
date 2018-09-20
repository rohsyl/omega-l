<?php
use Omega\Library\Entity\Entity;
?>
<body>
<!-- Header -->
<header id="header">
    <h1><a href="#"><img src="<?php echo Entity::Site()->template_directory_uri ?>/images/logo_yeux.svg"/> <?php echo Entity::Site()->name ?> <span><?php echo Entity::Site()->slogan ?></span></a></h1>
    <a href="#menu">Menu</a>
</header>

<!-- Nav -->
<?php
Entity::Menu()->setMenuHtmlStruct(array(
    'ul_main' => '<ul class="links">%1$s</ul>',
    'li_nochildren' => '<li class="nav-item-%3$s"><a href="%1$s">%2$s</a></li>',
    'li_nochildrenactiv' => '<li class="nav-item-%3$s active"><a href="%1$s">%2$s</a></li>',
    'li_children' => '<li class="nav-item-%3$s"><a href="%1$s">%2$s</a>%4$s</li>',
    'ul_children' => '<ul>%1$s</ul>',
    'li_childrenactiv' => '<li class="nav-item-%3$s active"><a href="%1$s">%2$s</a>%4$s</li>'
));
?>
<nav id="menu">
    <?php echo Entity::Menu()->getBySecurity(); ?>
</nav>

<!-- Banner -->
<!--
    To use a video as your background, set data-video to the name of your video without
    its extension (eg. images/banner). Your video must be available in both .mp4 and .webm
    formats to work correctly.
-->
<section id="banner">
    <div class="inner">
        <header>
            <img src="<?php echo Entity::Site()->template_directory_uri ?>/images/logo_yeux.svg"/>
        </header>
    </div>

</section>

<div id="main">

    <?php echo Entity::Page()->content ?>

</div>

<?php include(Entity::Site()->php_template_path . '/footer.php'); ?>
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

<div id="main">

    <!-- One -->
    <?php if(Entity::Page()->isVisibleTitle()) : ?>
    <section class="component-container">
        <div class="inner">
            <header>
                <h2><?php echo Entity::Page()->title ?></h2>
                <?php if($page->isVisibleSubTitle()) : ?>
                <p><?php echo Entity::Page()->subtitle ?></p>
                <?php endif ?>
            </header>
        </div>
    </section>
    <?php endif ?>

    <?php echo Entity::Page()->content ?>

</div>

<?php include(Entity::Site()->php_template_path . '/footer.php'); ?>
<?php
use Omega\Library\Entity\Entity;
?>

<body>

<!-- Header -->
<header id="header" class="alt">
    <div class="logo"><a href="index.html">Hielo <span>by TEMPLATED</span></a></div>
    <a href="#menu">Menu</a>
</header>

<!-- Nav -->
<?php //Personaliser la structure du menu via la method setMenuHtmlStruct.
//Exemple :
Entity::Menu()->setMenuHtmlStruct(array(
    'ul_main' => ' <ul class="links">%1$s</ul>',
    'li_nochildren' => '<li class="nav-item-%3$s"><a href="%1$s">%2$s</a></li>',
    'li_nochildrenactiv' => '<li class="nav-item-%3$s"><a href="%1$s">%2$s</a></li>',
    'li_children' => '<li class="dropdown nav-item-%3$s"><a href="%1$s" class="dropdown-toggle" data-toggle="dropdown" role="button" >%2$s <span class="caret"></span></a>%4$s</li>',
    'ul_children' => '<ul class="dropdown-menu">%1$s</ul>',
    'li_childrenactiv' => '<li class="dropdown nav-item-%3$s"><a href="%1$s" class="dropdown-toggle" data-toggle="dropdown">%2$s</a>%4$s</li>'
)); ?>
<nav id="menu">
    <?php echo Entity::Menu()->getBySecurity(); ?>
</nav>

<!-- One -->
<section id="One" class="wrapper style3">
    <div class="inner">
        <header class="align-center">
            <p><?php echo Entity::Page()->subtitle ?></p>
            <h2><?php echo Entity::Page()->title ?></h2>
        </header>
    </div>
</section>


<?php echo Entity::Page()->content ?>

<?php include(Entity::Site()->php_template_path . DS . 'footer.php'); ?>

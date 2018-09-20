<?php
    use Omega\Library\Entity\Entity;
?>

<body>

<nav class="navbar navbar-default" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Indigo</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <?php //Personaliser la structure du menu via la method setMenuHtmlStruct.
                //Exemple :
                Entity::Menu()->setMenuHtmlStruct(array(
                    'ul_main' => '<ul class="nav navbar-nav navbar-right">%1$s</ul>',
                    'li_nochildren' => '<li class="nav-item-%3$s"><a href="%1$s">%2$s</a></li>',
                    'li_nochildrenactiv' => '<li class="nav-item-%3$s"><a href="%1$s">%2$s</a></li>',
                    'li_children' => '<li class="dropdown nav-item-%3$s"><a href="%1$s" class="dropdown-toggle" data-toggle="dropdown" role="button" >%2$s <span class="caret"></span></a>%4$s</li>',
                    'ul_children' => '<ul class="dropdown-menu">%1$s</ul>',
                    'li_childrenactiv' => '<li class="dropdown nav-item-%3$s"><a href="%1$s" class="dropdown-toggle" data-toggle="dropdown">%2$s</a>%4$s</li>'
                )); ?>
            <?php echo Entity::Menu()->getBySecurity(); ?>
        </div><!-- /.navbar-collapse -->
    </div>
</nav>



<!-- START SECTION -->
<div class="section text-center background-dark dark-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2><?php echo Entity::Page()->title ?></h2>
                <p class="lead"><?php echo Entity::Page()->subtitle ?></p>
            </div>
        </div>
    </div>
</div>
<!--/.section -->

<?php echo Entity::Page()->content ?>

<?php include(Entity::Site()->php_template_path . DS . 'footer.php'); ?>

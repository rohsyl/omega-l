<?php
    use Omega\Library\Entity\Entity;
?>

<?php Entity::Menu()->setMenuHtmlStruct(array(
    'ul_main' => '<ul class="nav navbar-nav navbar-right">%1$s</ul>',
    'li_nochildren' => '<li class="nav-item-%3$s"><a href="%1$s">%2$s</a></li>',
    'li_nochildrenactiv' => '<li class="nav-item-%3$s"><a href="%1$s">%2$s</a></li>',
    'li_children' => '<li class="dropdown nav-item-%3$s"><a href="%1$s" class="dropdown-toggle" data-toggle="dropdown" role="button" >%2$s <span class="caret"></span></a>%4$s</li>',
    'ul_children' => '<ul class="dropdown-menu">%1$s</ul>',
    'li_childrenactiv' => '<li class="dropdown nav-item-%3$s"><a href="%1$s" class="dropdown-toggle" data-toggle="dropdown">%2$s <span class="caret"></span></a>%4$s</li>'
)); ?>

<!-- Navigation -->
<nav class="navbar navbar-default navbar-custom navbar-fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                Menu <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="<?php echo ABSPATH ?>"><?php echo Entity::Site()->name ?></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <?php echo Entity::Menu()->getBySecurity(); ?>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
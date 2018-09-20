<body>
<!-- Navigation -->
<nav class="navbar navbar-default navbar-custom navbar-fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                Menu <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="<?php echo ABSPATH ?>"><?php echo $site->name ?></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <?php $menu->setMenuHtmlStruct(array(
                'ul_main' => '<ul class="nav navbar-nav navbar-right">%1$s</ul>',
                'li_nochildren' => '<li class="nav-item-%3$s"><a href="%1$s">%2$s</a></li>',
                'li_nochildrenactiv' => '<li class="nav-item-%3$s"><a href="%1$s">%2$s</a></li>',
                'li_children' => '<li class="dropdown nav-item-%3$s"><a href="%1$s" class="dropdown-toggle" data-toggle="dropdown" role="button" >%2$s <span class="caret"></span></a>%4$s</li>',
                'ul_children' => '<ul class="dropdown-menu">%1$s</ul>',
                'li_childrenactiv' => '<li class="dropdown nav-item-%3$s"><a href="%1$s" class="dropdown-toggle" data-toggle="dropdown">%2$s</a>%4$s</li>'
            )); ?>
            <?php echo $menu->getBySecurity(); ?>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
<!-- Page Header -->
<!-- Set your background image for this header on the line below. -->
<header class="intro-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <div class="site-heading">
                    <h1><?php echo $page->title ?></h1>
                    <hr class="small">
                    <span class="subheading"><?php echo $page->subtitle ?></span>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Main Content -->
<?php echo $page->content ?>
<?php include($site->php_template_path . '/footer.php'); ?>
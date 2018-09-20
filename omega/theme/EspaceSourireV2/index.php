<?php
    use Omega\Library\Entity\Entity;
	use Omega\Library\Entity\ModuleArea;
?>
<body>

    <div id="wrapper">
		<div class="overlay"></div>
        <!-- Sidebar -->
        <nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
            <?php //Personaliser la structure du menu via la method setMenuHtmlStruct.
				//Exemple :
				Entity::Menu()->setMenuHtmlStruct(array(
					'ul_main' => '<ul class="nav sidebar-nav">%1$s</ul>',
					'li_nochildren' => '<li><a href="%1$s">%2$s</a></li>',
					'li_nochildrenactiv' => '<li class="active"><a href="%1$s">%2$s</a></li>',
					'li_children' => '<li class="dropdown nav-item-%3$s"><a href="%1$s" class="dropdown-toggle" data-toggle="dropdown" role="button" >%2$s <span class="caret"></span></a>%4$s</li>',
					'ul_children' => '<ul class="dropdown-menu">%1$s</ul>',
					'li_childrenactiv' => '<li class="dropdown nav-item-%3$s"><a href="%1$s" class="dropdown-toggle" data-toggle="dropdown">%2$s</a>%4$s</li>'
				)); ?>
			<?php echo Entity::Menu()->getBySecurity(); ?>
        </nav>
        <!-- /#sidebar-wrapper -->
		
		<!-- Main -->
		<section id="main">
			<button type="button" class="hamburger is-closed" data-toggle="offcanvas">
				<span class="hamb-top"></span>
				<span class="hamb-middle"></span>
				<span class="hamb-bottom"></span>
			</button
			
			<div class="container">
				<!-- Banner -->
				<section id="banner">
					<div class="inner logoFull">
						<?php ModuleArea::Display($page, 'logoFull', 'EspaceSourireV2');?>
					</div>
				</section>	
				<section class="content">
					<?php echo Entity::Page()->content ?>
				</section>
				
				<?php include(Entity::Site()->php_template_path . DS . 'footer.php'); ?>

		
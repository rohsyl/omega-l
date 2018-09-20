<?php
    use Omega\Library\Entity\Entity;
?>
<body>
<?php include(Entity::Site()->php_template_path . '/menu.php'); ?>
<!-- Page Header -->
<!-- Set your background image for this header on the line below. -->
<header class="intro-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <div class="site-heading">
                    <h1><?php echo Entity::Page()->title ?></h1>
                    <hr class="small">
                    <span class="subheading"><?php echo Entity::Page()->subtitle ?></span>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Main Content -->
<?php echo Entity::Page()->content ?>
<?php include('footer.php'); ?>
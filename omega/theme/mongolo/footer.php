<?php
use Omega\Library\Entity\Entity;
use Omega\Library\Entity\ModuleArea;
?>

<!-- START SECTION -->
<div class="section background-dark dark-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <?php ModuleArea::Display(Entity::Page(), 'footerLeft', 'mongolo') ?>
            </div>
            <div class="col-md-4 col-md-offset-1">
                <?php ModuleArea::Display(Entity::Page(), 'footerCenter', 'mongolo') ?>
            </div>
            <div class="col-md-4">
                <?php ModuleArea::Display(Entity::Page(), 'footerRight', 'mongolo') ?>
            </div>
            <div class="col-md-12 margin-top-md margin-bottom-md" style="opacity: .2;">
                <hr/>
            </div>
            <div class="col-md-12 margin-top-md text-center font-size-sm text-upercase">
                <p>© <strong>Mongolo Theme</strong>. Copyright mamène : Gaétan Huser. 2018.</p>
            </div>
        </div>
    </div>
</div>
<!--/.section -->
</body>
</html>
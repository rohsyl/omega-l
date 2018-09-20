<?php
    use Omega\Library\Entity\Entity;
    use Omega\Library\Entity\ModuleArea;
?>
<!-- Footer   -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <?php ModuleArea::Display(Entity::Page(), 'footer', 'clean_blog') ?>
                <p class="copyright text-muted">Powered by OmegaCMS</p>
            </div>
        </div>
    </div>
</footer>
</body>
</html>
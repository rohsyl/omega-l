<?php
    use Omega\Library\Entity\Entity;
    use Omega\Library\Entity\ModuleArea;
?>
        <footer id="footer">
            <div class="projecteur projecteur-right"></div>
            <div class="inner">
                <div class="flex flex-3">
                    <div class="col">
                        <?php ModuleArea::Display(Entity::Page(), 'footer_left', 'nocturne') ?>
                    </div>
                    <div class="col">
                        <?php ModuleArea::Display(Entity::Page(), 'footer_center', 'nocturne') ?>
                    </div>
                    <div class="col">
                        <?php ModuleArea::Display(Entity::Page(), 'footer_right', 'nocturne') ?>
                    </div>
                </div>
            </div>
            <div class="copyright">
                <?php ModuleArea::Display(Entity::Page(), 'copyright', 'nocturne') ?>
                &copy; Nocturne TDS. Powered by OmegaCMS</a>.
            </div>
        </footer>

    </body>
</html>
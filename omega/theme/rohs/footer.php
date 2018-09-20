<?php
use Omega\Library\Entity\Entity;
use Omega\Library\Entity\ModuleArea;
?>
<!-- Footer -->
<footer id="footer">
    <div class="inner">
        <div class="content">
            <section>
                <?php ModuleArea::Display(Entity::Page(), 'footer_left', 'rohs') ?>
            </section>
            <section>
                <?php ModuleArea::Display(Entity::Page(), 'footer_center', 'rohs') ?>
            </section>
            <section>
                <?php ModuleArea::Display(Entity::Page(), 'footer_right', 'rohs') ?>
            </section>
        </div>
        <div class="copyright">
            &copy; rohs.ch. Powered by OmegaCMS.
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="<?php echo Entity::Site()->template_directory_uri ?>/assets/js/jquery.min.js"></script>
<script src="<?php echo Entity::Site()->template_directory_uri ?>/assets/js/browser.min.js"></script>
<script src="<?php echo Entity::Site()->template_directory_uri ?>/assets/js/breakpoints.min.js"></script>
<script src="<?php echo Entity::Site()->template_directory_uri ?>/assets/js/util.js"></script>
<script src="<?php echo Entity::Site()->template_directory_uri ?>/assets/js/main.js"></script>

</body>
</html>
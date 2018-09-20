<?php
use Omega\Library\Entity\Entity;
use Omega\Library\Entity\ModuleArea;
?>
<!-- Footer -->
<footer id="footer">
    <div class="container">
        <?php ModuleArea::Display(Entity::Page(), 'footer', 'templated-hielo') ?>
    </div>
    <div class="copyright">
        &copy; Sylvain Roh. Powered by OmegaCMS.
    </div>
</footer>

</body>
</html>
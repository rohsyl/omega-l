<?php
    use Omega\Library\Entity\Menu;
?>

<div class="<?php echo $param['divClass'] ?>">
    <?php
        if($param['isVertical']) {
            $menu = new Menu();

            $menuHtmlStruct = array(
                'ul_main' => '<ul class="mtree bubba OM-vertical '.$param['ulClass'].'">%1$s</ul>',
                'li_nochildren' => '<li><a href="%1$s"><span>%2$s</span></a></li>',
                'li_nochildrenactiv' => '<li class="active"><a href="%1$s"><span>%2$s</span></a></li>',
                'li_children' => '<li><a href="%1$s"><span>%2$s</span></a>%3$s</li>',
                'ul_children' => '<ul>%1$s</ul>',
                'li_childrenactiv' => '<li class="active"><a href="%1$s"><span>%2$s</span></a>%4$s</li>'
            );


            $menu->setMenuHtmlStruct($menuHtmlStruct);

            echo $menu->getMenuById(false, $param['idMenu']);
        }
        else {
            $menu = new Menu();

            $menuHtmlStruct = array(
                'ul_main' => '<ul class="OM-horizontal '.$param['ulClass'].'">%1$s</ul>',
                'li_nochildren' => '<li><a href="%1$s"><span>%2$s</span></a></li>',
                'li_nochildrenactiv' => '<li class="active"><a href="%1$s"><span>%2$s</span></a></li>',
                'li_children' => '<li><a href="%1$s"><span>%2$s</span></a>%3$s</li>',
                'ul_children' => '<ul>%1$s</ul>',
                'li_childrenactiv' => '<li class="active"><a href="%1$s"><span>%2$s</span></a>%4$s</li>'
            );


            $menu->setMenuHtmlStruct($menuHtmlStruct);

            echo $menu->getMenuById(false, $param['idMenu']);
        }
    ?>
</div>
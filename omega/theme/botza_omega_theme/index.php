<?php
    use Omega\Library\Entity\Entity;
?>
<body>
<!--
    <?php //Personaliser la structure du menu via la method setMenuHtmlStruct.
          //Exemple :
        Entity::Menu()->setMenuHtmlStruct(array(
            'ul_main' => '<ul class="nav navbar-nav navbar-right">%1$s</ul>',
            'li_nochildren' => '<li class="nav-item-%3$s"><a href="%1$s">%2$s</a></li>',
            'li_nochildrenactiv' => '<li class="nav-item-%3$s"><a href="%1$s">%2$s</a></li>',
            'li_children' => '<li class="dropdown nav-item-%3$s"><a href="%1$s" class="dropdown-toggle" data-toggle="dropdown" role="button" >%2$s <span class="caret"></span></a>%4$s</li>',
            'ul_children' => '<ul class="dropdown-menu">%1$s</ul>',
            'li_childrenactiv' => '<li class="dropdown nav-item-%3$s"><a href="%1$s" class="dropdown-toggle" data-toggle="dropdown">%2$s</a>%4$s</li>'
        ));
    ?>
    <?php echo Entity::Menu()->getBySecurity(); ?>

    <h1><?php echo Entity::Page()->title ?></h1>
    <span class="subheading"><?php echo Entity::Page()->subtitle ?></span>

    <?php echo Entity::Page()->content ?>
-->


<nav class="navbar navbar-default container-fluid row">
    <div class="active col-md-2">Le camping<br/>du Botza</div>
    <div class="active col-md-offset-3 col-md-2"><a href="#">Menu</a></div>
    <div class="active col-md-offset-4 col-md-1"><a href="#">fr | en | de | es</a></div>
</nav>

<section class="row">
    <section class="col-md-5">
        <div class="col-md-offset-1 col-md-3">
            Chalets<br/>Bungalows
        </div>
    </section>
    <section class="col-md-7">
        <ul class="row">
            <li class="active"><a href="#">Chalets-Bungalows<span class="sr-only">(current)</span></a></li>
            <li class="active"><a href="#">Photos<span class="sr-only">(current)</span></a></li>
            <li class="active"><a href="#">Restaurant<span class="sr-only">(current)</span></a></li>
            <li class="active"><a href="#">Réservations<span class="sr-only">(current)</span></a></li>
            <li class="active"><a href="#">Infos Pratiques<span class="sr-only">(current)</span></a></li>
            <li class="active"><a href="#">Contact<span class="sr-only">(current)</span></a></li>
            <li class="active"><a href="#">Tarifs / Emplacements<span class="sr-only">(current)</span></a></li>
            <li class="active"><a href="#"><span class="glyphicon glyphicon-chevron-up"></span><span class="sr-only">(current)</span></a></li>
        </ul>
    </section>
</section>
<section class="row">
    <section class="col-md-4">
        <img src="" alt="image"/>
    </section>
    <section class="col-md-8">
        <section class="row">

            <table class="col-md-12">
                <tr class="row">
                    <th class="col-md-1"><span class="glyphicon glyphicon-user"></span></th>
                    <th class="col-md-3">12.03.17 - 06.07.17</th>
                    <th class="col-md-3">07.07.17 - 13.08.17</th>
                    <th class="col-md-3">14.08.17 - 23.10.17</th>
                </tr>
                <tr class="row">
                    <th class="col-md-1">1x</th>
                    <td class="col-md-3">65.- / pers</td>
                    <td class="col-md-3">70.- / pers</td>
                    <td class="col-md-3">65.- / pers</td>
                </tr>
                <tr class="row">
                    <th class="col-md-1">2x</th>
                    <td class="col-md-3">30.- / pers</td>
                    <td class="col-md-3">35.- / pers</td>
                    <td class="col-md-3">30.- / pers</td>
                </tr>
                <tr class="row">
                    <th class="col-md-1">3x</th>
                    <td class="col-md-3">15.- / pers</td>
                    <td class="col-md-3">15.- / pers</td>
                    <td class="col-md-3">15.- / pers</td>
                </tr>
                <tr class="row">
                    <th class="col-md-1">4x</th>
                    <td class="col-md-3">15.- / pers</td>
                    <td class="col-md-3">15.- / pers</td>
                    <td class="col-md-3">15.- / pers</td>
                </tr>
                <tr class="row">
                    <th class="col-md-1">5x</th>
                    <td class="col-md-3">15.- / pers</td>
                    <td class="col-md-3">15.- / pers</td>
                    <td class="col-md-3">15.- / pers</td>
                </tr>
            </table>
        </section>
        <section class="row">
            <div class="col-md-offset-2 col-md-2">A partir de 3 nuits 10% de rabais sur le séjour</div>
            <div class="col-md-offset-2 col-md-2">A partir de 7 nuits 10% de rabais sur le séjour</div>
            <div class="col-md-offset-2 col-md-2">A partir de 3 nuits 10% de rabais sur le séjour</div>
        </section>
    </section>
</section>






<?php include(Entity::Site()->php_template_path . DS . 'footer.php'); ?>
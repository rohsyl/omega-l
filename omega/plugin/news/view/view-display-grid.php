<div class="plugin plugin-news" data-plugin-placement="<?php echo $placement ?>">
    <div class="row">
    <?php foreach($posts as $p) : ?>
        <div class="col-sm-4">
            <div class="news-post">
                <header class="news-post-header">
                    <h3><?php echo $p->title ?></h3>
                <span>
                    <i class="fa fa-clock-o"></i> Posted on <?php echo date('d.m.Y', strtotime($p->created)) ?> at <?php echo date('H:i:s', strtotime($p->created)) ?>&nbsp;&nbsp;&nbsp;
                    <?php
                    $displayName = isset($p->user['userName']) && isset($p->user['userFistName']) ? $p->user['userName'] . ' ' . $p->user['userFistName'] : $p->user['userLogin']
                    ?>
                    <i class="fa fa-user"></i> <?php echo $displayName ?>
                </span>
                </header>
                <div class="news-post-text">
                    <?php
                    if($pluginNewsSimpleView)
                    {
                        echo $p->text;
                    }
                    else
                    {

                        ?>
                        <div><?php echo $p->hat; ?></div>
                        <a href="?post=<?php echo $p->id ?>" class="btn btn-xs btn-primary"><?php oo('Read more') ?> <i class="fa fa-angle-double-right"></i></a>
                        <?php

                    }
                    ?>
                </div>
            </div>
        </div>
    <?php endforeach ?>
    </div>
</div>
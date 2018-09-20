<?php
use Omega\Library\Entity\Media;
use Omega\Library\Util\Url;
use Omega\Library\Util\Util;
use function Omega\Library\oo;
?>

<?php
    $url = strtok($_SERVER["REQUEST_URI"],'?');
?>
<div class="plugin plugin-news" data-plugin-placement="<?php echo $placement ?>">
    <div class="news-post">
        <div class="news-nav">
            <ul class="pager">
                <?php if($older != null) : ?>
                <li class="previous">
                    <a href="<?php echo $url ?>?post=<?php echo $older->id ?>">&larr; Précédant</a>
                </li>
                <?php else: ?>
                <li class="previous disabled"><a>&larr; Précédant</a></li>
                <?php endif ?>
                <li><a href="<?php echo $url ?>" data-toggle="tooltip" data-placement="bottom" title="<?php oo('Back to list') ?>"><i class="fa fa-list"></i></a></li>
                <?php if($newer != null) : ?>
                <li class="next">
                    <a href="<?php echo $url ?>?post=<?php echo $newer->id ?>">Suivant &rarr;</a>
                </li>
                <?php else: ?>
                    <li class="next disabled"><a>Suivant &rarr;</a></li>
                <?php endif ?>
            </ul>
        </div>
        <br />

        <?php if(isset($post)) { ?>
            <h1><?php echo $post->title ?></h1>

            <!-- Author -->
            <p class="lead">

                <span class="glyphicon glyphicon-time"></span>  <?php echo date('d.m.Y', strtotime($post->created)) ?>,


                <i class="fa fa-user"></i> <?php
                $displayName = isset($post->user->userName) && isset($post->user->userFistName) ? $post->user->userName . ' ' . $post->user->userFistName : $post->user->userLogin
                ?>
                <?php echo $displayName ?>
            </p>

            <hr>
            <div class="row">
                <?php if(isset($post->idImage) && $post->idImage != 0) : ?>

                    <div class="col-sm-3">
                        <?php
                        $media = new Media($post->idImage);
                        $url = Url::CombAndAbs(ABSPATH, $media->path);
                        ?>
                        <!-- Preview Image -->
                        <img src="<?php echo $url ?>" class="news-post-image" alt="<?php echo $post->title ?>" />
                    </div>
                    <div class="col-sm-9">
                        <!-- Post Content -->
                        <?php echo $post->text; ?>
                    </div>

                <?php else: ?>
                    <div class="col-sm-12">
                        <!-- Post Content -->
                        <?php echo $post->text; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php } else { ?>
            <p class="text-center">
                This post does not exists...<br /><br />
                <a href="<?php echo $url ?>" class="btn btn-default btn-lg"><?php oo('Back to list') ?></a>
            </p>
        <?php } ?>
    </div>
</div>
<?php
use Omega\Library\Entity\Media;
use Omega\Library\Util\Url;
use function Omega\Library\oo;
?>
<div class="plugin plugin-news" data-plugin-placement="<?php echo $placement ?>">
    <?php if(sizeof($posts) == 0): ?>
        <p class="text-center">Aucun article</p>
    <?php endif; ?>
	<?php foreach($posts as $p) : ?>
	<div class="news-post">
		<header class="news-post-header">
            <h3><a href="?post=<?php echo $p->id ?>"><?php echo $p->title ?></a></h3>
			<span>
				<i class="fa fa-clock-o"></i> le <?php echo date('d.m.Y', strtotime($p->created)) ?>
				<?php
					$displayName = isset($p->user->userName) && isset($p->user->userFistName) ? $p->user->userName . ' ' . $p->user->userFistName : $p->user->userLogin
				?>
				<i class="fa fa-user"></i> <?php echo $displayName ?>
			</span>
		</header>
		<div class="news-post-text">
            <div class="row">
                <?php if(isset($p->idImage) && $p->idImage != 0) : ?>

                    <div class="col-sm-3">
                        <?php
                        $media = new Media($p->idImage);
                        $url = Url::CombAndAbs(ABSPATH, $media->path);
                        ?>
                        <!-- Preview Image -->
                        <img src="<?php echo $url ?>" class="news-post-image" alt="<?php echo $p->title ?>" />
                    </div>
                    <div class="col-sm-9">
                        <!-- Post Content -->
                        <?php echo $p->text; ?>
                    </div>

                <?php else: ?>
                    <div class="col-sm-12">
                        <!-- Post Content -->
                        <?php echo $p->text; ?>
                    </div>
                <?php endif; ?>
            </div>
		</div>
	</div>
	<?php endforeach ?>
</div>
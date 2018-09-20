<?php
    use Omega\Library\Util\OmegaUtil;
    use Omega\Library\Entity\Entity;
	use Omega\Library\Util\Url;
?>
<!DOCTYPE HTML>
<html>
	<head>
	
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php OmegaUtil::renderMeta() ?>
		<title><?php echo Entity::Site()->name ?> - <?php echo Entity::Page()->title ?></title>
		<link rel="stylesheet" href="<?php echo Url::CombAndAbs(ABSPATH, 'assets/css/bootstrap.min.css') ?>">
		<link href="<?= Entity::Site()->template_directory_uri ?>/css/font-awesome.min.css" rel="stylesheet">
		<link href="<?= Entity::Site()->template_directory_uri ?>/css/styles.css" rel="stylesheet">
		<!-- Scripts -->
		
		<script src="<?= Entity::Site()->template_directory_uri ?>/js/jquery.min.js"></script>
		<script src="<?= Entity::Site()->template_directory_uri ?>/js/jquery.poptrox.min.js"></script>
		<script src="<?= Entity::Site()->template_directory_uri ?>/js/jquery.scrolly.min.js"></script>
		<script src="<?php echo Url::CombAndAbs(ABSPATH, 'assets/js/bootstrap.min.js') ?>"></script>
		<script src="<?= Entity::Site()->template_directory_uri ?>/js/skel.min.js"></script>
		<script src="<?= Entity::Site()->template_directory_uri ?>/js/util.js"></script>
		<script src="<?= Entity::Site()->template_directory_uri ?>/js/scripts.js"></script>

		<?php Entity::Page()->RenderCssTheme() ?>
		<?php OmegaUtil::renderDependencies() ?>
		
	</head>
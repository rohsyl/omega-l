<?php
use Omega\Library\Entity\Page;
use Omega\Library\Util\Util;

$componentsView = array();
if(isset($page['value'])){
    $page = new Page($page['value']);
    $componentsView = $page->getComponentsViewArray();
}

?>

<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    <?php $i = 0; ?>
    <?php foreach($componentsView as $v) : ?>
        <li role="presentation" class="<?php echo $i == 0 ? 'active' : '' ?>">
            <a href="#<?php echo Util::toTextKey($v['title']) ?>" aria-controls="home" role="tab" data-toggle="tab">
                <?php echo $v['title'] ?>
            </a>
        </li>
        <?php $i++ ?>
    <?php endforeach ?>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <?php $i = 0; ?>
    <?php foreach($componentsView as $v) : ?>
        <div role="tabpanel" class="tab-pane <?php echo $i == 0 ? 'active' : '' ?>" id="<?php echo Util::toTextKey($v['title']) ?>">
            <?php echo $v['html'] ?>
        </div>
        <?php $i++ ?>
    <?php endforeach ?>
</div>
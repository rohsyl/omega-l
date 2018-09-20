<?php
use Omega\Library\Entity\Page;

$componentsView = array();
$colClass = 'col-sm-' . (12 / $countCol);
if(isset($page['value'])){
    $page = new Page($page['value']);
    $componentsView = $page->getComponentsViewArray();
}

?>

<div class="row">
    <?php foreach($componentsView as $v) : ?>
        <div class="<?php echo $colClass ?>">
            <?php echo $v['html'] ?>
        </div>
    <?php endforeach ?>
</div>

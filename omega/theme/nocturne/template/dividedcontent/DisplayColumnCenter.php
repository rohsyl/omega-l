<?php
use Omega\Library\Entity\Page;

$componentsView = array();
$colClass = (12 / $countCol) .'u';
if(isset($page['value'])){
    $page = new Page($page['value']);
    $componentsView = $page->getComponentsViewArray();
}

?>

<div class="row">
    <?php foreach($componentsView as $v) : ?>
        <div class="<?php echo $colClass ?> align-center">
            <?php echo $v['html'] ?>
        </div>
    <?php endforeach ?>
</div>

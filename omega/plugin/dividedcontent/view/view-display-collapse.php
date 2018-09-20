<?php
use Omega\Library\Entity\Page;
use Omega\Library\Util\Util;

$componentsView = array();
if(isset($page['value'])){
    $page = new Page($page['value']);
    $componentsView = $page->getComponentsViewArray();
}

?>

<div class="panel-group" id="accordion<?php echo $id ?>" role="tablist" aria-multiselectable="true">

    <?php $i = 0; ?>
    <?php foreach($componentsView as $v) : ?>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading<?php echo $i . '-' . $id ?>">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion<?php echo $id ?>" href="#collapse<?php echo $i . '-' . $id ?>" aria-expanded="true" aria-controls="collapse<?php echo $i . '-' . $id ?>">
                        <?php echo $v['title'] ?>
                    </a>
                </h4>
            </div>
            <div id="collapse<?php echo $i . '-' . $id ?>" class="panel-collapse collapse <?php echo $i == 0 ? 'in' : '' ?>" role="tabpanel" aria-labelledby="heading<?php echo $i . '-' . $id ?>">
                <div class="panel-body">
                    <?php echo $v['html'] ?>
                </div>
            </div>
        </div>
        <?php $i++ ?>
    <?php endforeach ?>
</div>
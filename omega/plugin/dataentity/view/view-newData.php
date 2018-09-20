<?php
use Omega\Plugin\Dataentity\Library\Form\DataEntityType;
use function Omega\Library\__;

    $url = $this->getAdminLink('newData', array('id' => $entity->id))
?>


<br />
<ol class="breadcrumb">
    <li><a href="<?php echo $this->getAdminLink('index') ?>"><i class="fa fa-home"></i> Data Entity</a></li>
    <li><a href="<?php echo $this->getAdminLink('manageData', array('id' => $entity->id)) ?>"><i class="fa fa-database"></i> <?php echo $entity->title ?></a></li>
    <li><i class="fa fa-plus"></i> Add a new <?php echo $entity->title ?></li>
</ol>

<form method="post" action="<?php echo $url ?>">
    <?php echo DataEntityType::FormRenderByname($entity->name); ?>
    <hr />
    <p>
        <input type="submit" class="btn btn-primary" name="btnNewData" value="<?php __('Save') ?>">
    </p>
</form>
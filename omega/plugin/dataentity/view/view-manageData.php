<?php
use Omega\Library\Util\TableBuilder\TableBuilder;
use Omega\Library\Util\TableBuilder\TableBuilderActions;
use Omega\Library\Util\TableBuilder\TableBuilderActionHead;
use Omega\Library\Util\TableBuilder\TableBuilderActionItem;
use function Omega\Library\__;

?>

<br />
<ol class="breadcrumb">
    <li><a href="<?php echo $this->getAdminLink('index') ?>"><i class="fa fa-home"></i> Data Entity</a></li>
    <li><i class="fa fa-database"></i> <?php echo $entity->title ?></li>
</ol>

<?php


$columnLabels = array('#');
$columnNames = array('id');
foreach($properties as $prop){
    if($prop->heading){
        $columnLabels[] = $prop->title;
        $columnNames[] = $prop->id;
    }
}

$actions = new TableBuilderActions();
$actions->addHeaderAction(new TableBuilderActionHead(
        $this->getAdminLink('newData', array('id' => $entity->id)),
        '<i class="fa fa-plus"></i> Add '. $entity->title,
        'btn btn-default btn-xs')
);
$actions->addItemAction(new TableBuilderActionItem(
    $this->getAdminLink('editData', array('id' => ':id')),
    __('Edit', true),
    'id',
    ''
));
$actions->addItemAction(new TableBuilderActionItem(
    $this->getAdminLink('deleteData', array('id' => ':id')),
    __('Delete', true),
    'id',
    'delete text-danger',
    array(
            'url' => $this->getAdminLink('deleteData', array('id' => ':id'))
    )
));

TableBuilder::Build($datas, $columnLabels, $columnNames, $actions, false)
?>
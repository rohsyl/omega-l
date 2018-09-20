<?php
    use function Omega\Library\__;
    use Omega\Library\Util\TableBuilder\TableBuilder;
    use Omega\Library\Util\TableBuilder\TableBuilderActions;
    use Omega\Library\Util\TableBuilder\TableBuilderActionHead;
    use Omega\Library\Util\TableBuilder\TableBuilderActionItem;
    use Omega\Library\Util\TableBuilder\TableBuilderActionColumnItem;
?>


<?php
/*
$actions = new TableBuilderActions();
$actions->addHeaderAction(new TableBuilderActionHead(
    $this->getAdminLink('addEntity'),
    '<i class="fa fa-plus"></i> ' . __('Add', true),
    'btn btn-primary btn-xs')
);
$actions->addItemAction(new TableBuilderActionItem(
    $this->getAdminLink('editEntity', array('id' => ':id')),
    __('Edit', true),
    'id',
    '')
);
$actions->addItemAction(new TableBuilderActionItem(
    $this->getAdminLink('deleteEntity', array('id' => ':id')),
    __('Delete', true),
    'id',
    'text-danger delete',
    array(
        'url' => $this->getAdminLink('deleteEntity', array('id' => ':id'))
    )
    )
);
$actions->addActionsOnColumn('title', new TableBuilderActionColumnItem(
    $this->getAdminLink('editEntity', array('id' => ':id')),
    'title',
    'id',
    '')
);

TableBuilder::Build($entities, array('Entity'), array('title'), $actions);
*/
?>

<br />
<ol class="breadcrumb">
    <li><a href="<?php echo $this->getAdminLink('index') ?>"><i class="fa fa-home"></i> Data Entity</a></li>
    <li><i class="fa fa-object-group"></i> Layouts</li>
</ol>

<div class="alert alert-info">
    <strong><i class="fa fa-info-circle"></i> Information</strong>
    Layouts are used to define the structure when displaying the dataentity module.
</div>
<?php

$actions = new TableBuilderActions();
$actions->addHeaderAction(new TableBuilderActionHead(
        $this->getAdminLink('addLayout'),
        '<i class="fa fa-plus"></i> New layout',
        'btn btn-default btn-xs')
);
$actions->addItemAction(new TableBuilderActionItem(
    $this->getAdminLink('editLayout', array('id' => ':id')),
    __('Edit', true),
    'id',
    ''
));
$actions->addItemAction(new TableBuilderActionItem(
    $this->getAdminLink('deleteLayout', array('id' => ':id')),
    __('Delete', true),
    'id',
    'delete text-danger',
    array(
        'url' => $this->getAdminLink('deleteLayout', array('id' => ':id'))
    )
));

TableBuilder::Build($layouts, array('Name'), array('name'), $actions, true);
?>
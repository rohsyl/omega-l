<?php
use function Omega\Library\__;
use Omega\Library\Util\TableBuilder\TableBuilder;
use Omega\Library\Util\TableBuilder\TableBuilderActions;
use Omega\Library\Util\TableBuilder\TableBuilderActionHead;
use Omega\Library\Util\TableBuilder\TableBuilderActionItem;

$actions = new TableBuilderActions();
$actions->addHeaderAction(new TableBuilderActionHead(
        '#',
        '<i class="fa fa-plus"></i> ' . __('Add', true),
        'btn btn-primary btn-xs btnAddView')
);
$actions->addItemAction(new TableBuilderActionItem(
        '#:id',
        __('Fast Edit', true),
        'id',
        'btnEditView')
);
$actions->addItemAction(new TableBuilderActionItem(
        $this->getAdminLink('editViewFullPage', array('id' => ':id')),
        __('Edit', true),
        'id',
        'btn-link')
);
$actions->addItemAction(new TableBuilderActionItem(
        '#:id',
        __('Delete', true),
        'id',
        'text-danger btnDeleteView')
);
TableBuilder::Build($views, array('Name'), array('name'), $actions);
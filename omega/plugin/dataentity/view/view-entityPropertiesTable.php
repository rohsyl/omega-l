<?php
use function Omega\Library\__;
use Omega\Library\Util\TableBuilder\TableBuilder;
use Omega\Library\Util\TableBuilder\TableBuilderActions;
use Omega\Library\Util\TableBuilder\TableBuilderActionHead;
use Omega\Library\Util\TableBuilder\TableBuilderActionItem;
use Omega\Library\Util\TableBuilder\TableBuilderFormatColumn;
?>


<?php
$actions = new TableBuilderActions();
$actions->addHeaderAction(new TableBuilderActionHead(
        '#',
        '<i class="fa fa-plus"></i> ' . __('Add', true),
        'btn btn-primary btn-xs btnAddProperty')
);
$actions->addItemAction(new TableBuilderActionItem(
        '#:id',
        __('Edit', true),
        'id',
        'btnEditProperty')
);
$actions->addItemAction(new TableBuilderActionItem(
        '#:id',
        __('Delete', true),
        'id',
        'text-danger btnDeleteProperty')
);
$actions->addFormatColumn(
    'mandatory',
    new TableBuilderFormatColumn(function ($value) {
        return $value ? __('Yes', true) : __('No', true);
    })
);
$actions->addFormatColumn(
    'heading',
    new TableBuilderFormatColumn(function ($value) {
        return $value ? __('Yes', true) : __('No', true);
    })
);
TableBuilder::Build($properties, array('Property', 'Is Mandatory', 'Is Heading'), array('title', 'mandatory', 'heading'), $actions);
?>

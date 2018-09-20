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
    <li><i class="fa fa-home"></i> Data Entity</li>
</ol>

<p>
    <a href="<?php echo $this->getAdminLink('addEntity') ?>" class="btn btn-default"><i class="fa fa-plus"></i> Add entity</a>
    <a href="<?php echo $this->getAdminLink('layout') ?>" class="btn btn-default"><i class="fa fa-object-group"></i> Layouts</a>
</p>
<div class="row">
<?php foreach($entities as $entity): ?>
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
        <div class="card">
            <h4 class="page-header" style="margin-top:10px;"><?php echo $entity->title ?></h4>
            <div class="row">
                <div class="col-xs-3">
                    <i class="fa fa-database fa-5x"></i>
                </div>
                <div class="col-xs-9 text-right">
                    <p><a href="<?php echo $this->getAdminLink('manageData', array('id' => $entity->id)) ?>" class="btn btn-primary btn-sm"><i class="fa fa-database"></i> Manage data</a></p>
                    <p><a href="<?php echo $this->getAdminLink('editEntity', array('id' => $entity->id)) ?>" class="btn btn-default btn-sm"><i class="fa fa-cog"></i> Edit entity</a></p>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>

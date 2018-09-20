<?php
use Omega\Library\Util\Url;

$url = $this->getAdminLink('editEntity', array('id' => $entity->id));
$urlDelete = $this->getAdminLink('deleteEntity', array('id' => $entity->id));
?>
<script src="<?php echo Url::CombAndAbs(ABSPATH, '/assets/js/ace/ace.js'); ?>"></script>
<script src="<?php echo Url::CombAndAbs(ABSPATH, '/assets/js/ace/ext-language_tools.js'); ?>"></script>


<br />
<ol class="breadcrumb">
    <li><a href="<?php echo $this->getAdminLink('index') ?>"><i class="fa fa-home"></i> Data Entity</a></li>
    <li><i class="fa fa-cog"></i> Edit <?php echo $entity->title ?> definition</li>
</ol>

<form class="form-horizontal" method="post" action="<?php echo $url ?>">

    <!-- Text input-->
    <div class="form-group">
        <label class="col-md-4 control-label" for="entityName">Entity Name :</label>
        <div class="col-md-4">
            <input id="entityName" name="entityName" value="<?php echo $entity->title ?>" type="text" placeholder="Entity Name" class="form-control input-md">
            <span class="help-block">The name of the entity</span>
        </div>
    </div>

    <!-- Button -->
    <div class="form-group">
        <label class="col-md-4 control-label" for="addEntity"></label>
        <div class="col-md-4">
            <button id="addEntity" name="editEntity" class="btn btn-primary">Save Entity</button>&nbsp;
            <a href="<?php echo $urlDelete ?>" class="btn btn-danger delete" data-url="<?php echo $urlDelete ?>">Supprimer</a>
        </div>
    </div>
</form>

<h3 class="page-header">Entity Properties</h3>
<div class="tablePropertiesContainer">
    Loading...
</div>

<h3 class="page-header">Entity Views</h3>
<div class="tableViewsContainer">
    Loading...
</div>

<script>
    $(function(){
        var entityId = <?php echo $entity->id ?>;
        var body = 'body';
        var btnAddProperty = '.btnAddProperty';
        var btnEditProperty = '.btnEditProperty';
        var btnDeleteProperty = '.btnDeleteProperty';
        var btnAddView = '.btnAddView';
        var btnEditView = '.btnEditView';
        var btnDeleteView = '.btnDeleteView';
        var $tablePropertiesContainer = $('.tablePropertiesContainer');
        var $tableViewsContainer = $('.tableViewsContainer');


        // on add
        $(body).on( "click", btnAddProperty, function(e) {
            e.preventDefault();

            var url = omega.plugin.mvc.url('dataentity', 'addPropertyForm');
            omega.ajax.query(url, {}, omega.ajax.GET, function(data){
                var mId = omega.modal.open(__('Add a property'), data, __('Create'), function () {

                    var data = {
                        entityId: entityId,
                        name: $('#propName').val(),
                        description : $('#propDescription').val(),
                        type: $('#propType').val(),
                        mandatory: $('#propMandatory-0').is(':checked') ? 1 : 0,
                        heading: $('#propHeading-0').is(':checked') ? 1 : 0
                    };

                    if(data.name.length === 0){
                        omega.notice.error(undefined, __('Please write a name'));
                        return false;
                    }

                    var url = omega.plugin.mvc.url('dataentity', 'addProperty');
                    omega.ajax.query(url, data, omega.ajax.POST, function(data){
                        if(data.result){
                            omega.notice.success(undefined, __('Property added successfully !'));
                        }
                        else{
                            omega.notice.error(undefined, __('Error while adding Property...'));
                        }
                        loadTableProperties();
                        omega.modal.hide(mId);
                    }, undefined, {dataType: 'json'});

                }, 'modal-lg');
            });
            return false;
        });

        // on edit
        $(body).on('click', btnEditProperty, function(e){
            e.preventDefault();

            var id = parseInt($(this).attr('href').substr(1));
            var url = omega.plugin.mvc.url('dataentity', 'editPropertyForm');
            omega.ajax.query(url, {id : id}, omega.ajax.GET, function(data){
                var mId = omega.modal.open(__('Edit a property'), data, __('Save'), function () {
                    var data = {
                        name: $('#propName').val(),
                        description : $('#propDescription').val(),
                        type: $('#propType').val(),
                        mandatory: $('#propMandatory-0').is(':checked') ? 1 : 0,
                        heading: $('#propHeading-0').is(':checked') ? 1 : 0
                    };

                    if(data.name.length === 0){
                        omega.notice.error(undefined, __('Please write a name'));
                        return false;
                    }

                    var url = omega.plugin.mvc.url('dataentity', 'editProperty', { id : id });
                    omega.ajax.query(url, data, omega.ajax.POST, function(data){
                        if(data.result){
                            omega.notice.success(undefined, __('Property updated successfully !'));
                        }
                        else{
                            omega.notice.error(undefined, __('Error while updating Property...'));
                        }
                        loadTableProperties();
                        omega.modal.hide(mId);
                    }, undefined, {dataType: 'json'});

                }, 'modal-lg');
            });

            return false;
        });

        // on delete
        $(body).on('click', btnDeleteProperty, function(e){
            e.preventDefault();

            var id = parseInt($(this).attr('href').substr(1));

            omega.modal.confirm(__('Do you really want to delete this property ?'), function(result){
                if(result){
                    var url = omega.plugin.mvc.url('dataentity', 'deleteProperty', { id : id });
                    omega.ajax.query(url, {id : id}, omega.ajax.POST, function(data){
                        if(data.result){
                            omega.notice.success(undefined, __('Property deleted successfully !'));
                        }
                        else{
                            omega.notice.error(undefined, __('Error while deleting Property...'));
                        }
                        loadTableProperties();
                    }, undefined, {dataType: 'json'});
                }
            }, 'btn-danger');

            return false;
        });

        //on add
        $(body).on('click', btnAddView, function(e){
            e.preventDefault();

            var url = omega.plugin.mvc.url('dataentity', 'addViewForm');
            omega.ajax.query(url, {}, omega.ajax.GET, function(data){
                var mId = omega.modal.open(__('Add a view'), data, __('Create view'), function(){
                    var data = {
                        entityId: entityId,
                        name : $('#viewName').val()
                    };

                    if(data.name.length === 0){
                        omega.notice.error(undefined, __('Please write a name'));
                        return false;
                    }

                    var url = omega.plugin.mvc.url('dataentity', 'addView');
                    omega.ajax.query(url, data, omega.ajax.POST, function (data) {
                        if(data.result){
                            omega.notice.success(undefined, __('View added successfully !'));
                        }
                        else{
                            omega.notice.error(undefined, __('Error while added View...'));
                        }
                        loadTableViews();
                        omega.modal.hide(mId);
                    }, undefined, {dataType: 'json'});
                });
            });

            return false;
        });

        $(body).on('click', btnEditView, function(e){
            e.preventDefault();

            var id = parseInt($(this).attr('href').substr(1));
            var url = omega.plugin.mvc.url('dataentity', 'editViewForm', { id: id});
            omega.ajax.query(url, {}, omega.ajax.GET, function(data){
                var mId = omega.modal.open(__('Edit view'), data, __('Save'), function(){
                var editor = ace.edit("viewCode");
                    var data = {
                        entityId: entityId,
                        name : $('#viewName').val(),
                        view : editor.getValue()
                    };

                    if(data.name.length === 0){
                        omega.notice.error(undefined, __('Please write a name'));
                        return false;
                    }

                    var url = omega.plugin.mvc.url('dataentity', 'editView',  { id: id});
                    omega.ajax.query(url, data, omega.ajax.POST, function(data){
                        if(data.result){
                            omega.notice.success(undefined, __('View updated successfully !'));
                        }
                        else{
                            omega.notice.error(undefined, __('Error while updating View...'));
                        }
                        loadTableViews();
                        omega.modal.hide(mId);
                    }, undefined, {dataType: 'json'});
                }, 'modal-lg');
            });

            return false;
        });

        $(body).on('click', btnDeleteView, function(e){
            e.preventDefault();
            var id = parseInt($(this).attr('href').substr(1));

            omega.modal.confirm(__('Do you really want to delete this view ?'), function(result){
                if(result){
                    var url = omega.plugin.mvc.url('dataentity', 'deleteView', { id : id });
                    omega.ajax.query(url, {id : id}, omega.ajax.POST, function(data){
                        if(data.result){
                            omega.notice.success(undefined, __('View deleted successfully !'));
                        }
                        else{
                            omega.notice.error(undefined, __('Error while deleting View...'));
                        }
                        loadTableViews();
                    }, undefined, {dataType: 'json'});
                }
            }, 'btn-danger');

            return false;
        });

        function loadTableProperties(){
            var url = omega.plugin.mvc.url('dataentity', 'entityPropertiesTable');
            omega.ajax.query(url, {id : entityId}, omega.ajax.GET, function(data){
                $tablePropertiesContainer.html(data);
            });
        }
        loadTableProperties();


        function loadTableViews(){
            var url = omega.plugin.mvc.url('dataentity', 'entityViewsTable');
            omega.ajax.query(url, {id : entityId}, omega.ajax.GET, function(data){
                $tableViewsContainer.html(data);
            });
        }
        loadTableViews();
    });
</script>
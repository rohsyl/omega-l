<div class="row">
    <div class="col-sm-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ __('Modules') }}
                <button id="add-content-module" class="btn btn-xs btn-primary" style="float:right"><span class="glyphicon glyphicon-plus"></span></button>
            </div>
            <div class="panel-body" id="modules-container">
                {{ __('Loading') }}...
            </div>
        </div>
    </div>
    <div class="col-sm-9">
        <div class="row" id="modulearea-list">
        </div>
    </div>
</div>
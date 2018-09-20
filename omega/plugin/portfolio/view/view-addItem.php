<?php echo $this->partialView('menu');
$action = $this->getAdminLink('addItem');
?>
<form class="form-horizontal" method="post" action="<?php echo $action ?>">
    <!-- Text input-->
    <div class="form-group">
        <label class="col-md-4 control-label" for="name">Name</label>
        <div class="col-md-4">
            <input id="name" name="name" placeholder="Name" class="form-control input-md" type="text">

        </div>
    </div>

    <!-- Select Basic -->
    <div class="form-group">
        <label class="col-md-4 control-label" for="category">Category</label>
        <div class="col-md-4">
            <select id="category" name="category" class="form-control">
                <?php foreach($categories as $c) : ?>
                    <option value="<?php echo $c->id ?>"><?php echo $c->name ?></option>
                <?php endforeach ?>
            </select>
        </div>
    </div>

    <!-- Button -->
    <div class="form-group">
        <label class="col-md-4 control-label" for="btnSaveItem"></label>
        <div class="col-md-4">
            <button id="btnSaveItem" name="btnSaveItem" class="btn btn-primary" type="submit">Save</button>
        </div>
    </div>
</form>

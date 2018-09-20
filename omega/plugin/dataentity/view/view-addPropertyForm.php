<div class="row ">
    <div class="col-sm-6">
        <div>
            <!-- Text input-->
            <div class="form-group">
                <label class="control-label" for="propName">Name</label>
                <input id="propName" name="propName" type="text" placeholder="Name" class="form-control input-md">
                <span class="help-block">The name of the property</span>
            </div>

            <!-- Select Basic -->
            <div class="form-group">
                <label class="control-label" for="propType">Type</label>
                <select id="propType" name="propType" class="form-control">
                    <?php foreach($types as $type): ?>
                        <option value="<?php echo $type['name'] ?>"><?php echo $type['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Multiple Checkboxes (inline) -->
            <div class="form-group">
                <label class="control-label" for="propMandatory">Mandatory</label><br />
                <label class="checkbox-inline" for="propMandatory-0">
                    <input type="checkbox" name="propMandatory" id="propMandatory-0" value="true">
                    Yes
                </label>
            </div>
            <!-- Multiple Checkboxes (inline) -->
            <div class="form-group">
                <label class="control-label" for="propHeading">Heading</label><br />
                <label class="checkbox-inline" for="propHeading-0">
                    <input type="checkbox" name="propHeading" id="propHeading-0" value="true">
                    Yes
                </label>
            </div>
        </div>

    </div>
    <div class="col-sm-6">
        <div>
            <!-- Textarea -->
            <div class="form-group">
                <label class="control-label" for="propDescription">Description</label>
                <textarea class="form-control" id="propDescription" name="propDescription" placeholder="Description"></textarea>
            </div>
        </div>
    </div>
</div>


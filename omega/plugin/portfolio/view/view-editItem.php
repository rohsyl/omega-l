<?php
use Omega\Library\Entity\Media;

echo $this->partialView('menu');
$action = $this->getAdminLink('editItem', array('id' => $_GET['id']));

$tab = isset($_GET['tab']) ? $_GET['tab'] : 'info';
?>

<div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" <?php if($tab == 'info') : ?> class="active" <?php endif ?>><a href="#info" aria-controls="info" role="tab" data-toggle="tab">Informations</a></li>
    <li role="presentation" <?php if($tab == 'slider') : ?> class="active" <?php endif ?>><a href="#slider" aria-controls="slider" role="tab" data-toggle="tab">Slider</a></li>
      <li role="presentation" <?php if($tab == 'cp') : ?> class="active" <?php endif ?>><a href="#cp" aria-controls="cp" role="tab" data-toggle="tab">Custom Properties</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane <?php if($tab == 'info') : ?> active <?php endif ?>" id="info"><?php get_info_tab_content($item, $categories, $action) ?></div>
    <div role="tabpanel" class="tab-pane <?php if($tab == 'slider') : ?> active <?php endif ?>" id="slider"><?php get_slider_tab_content($slider, $action) ?></div>
    <div role="tabpanel" class="tab-pane <?php if($tab == 'cp') : ?> active <?php endif ?>" id="cp"><?php get_cp_tab_content($cpValues, $action) ?></div>
  </div>

</div>

<?php function get_slider_tab_content($sliders, $action) { ?>
    <br />
    <a class="btn btn-default" href="<?php echo $action ?>&slider_action=add_new_slide">Add new slide</a>
    <hr />
    <form class="form-horizontal" action="<?php echo $action ?>&slider_action=save" method="POST">
  <?php foreach($sliders as $slide) : ?>
    <div class="row">
      <div class="col-sm-8"> <?php

        $media = new Media($slide->fkMedia);
        $name = $media->name;
        $id = $media->id;
        ?>
        <div class="input-group">
          <input value="<?php echo $name ?>" id="slider-name-<?php echo $slide->id ?>" name="slider-name-<?php echo $slide->id ?>" placeholder="Image " class="form-control input-md" type="text">
          <input value="<?php echo $id ?>" id="slider-<?php echo $slide->id ?>" name="slider[<?php echo $slide->id ?>]" type="hidden">
          <span id="mediaChooseSlide-<?php echo $slide->id ?>" class="input-group-addon btn btn-primary">Choisir</span>
        </div>
      </div>
      <div class="col-sm-4">
        <a class="btn btn-danger" href="<?php echo $action ?>&slider_action=delete_image&slide_id=<?php echo $slide->id ?>">Delete</a>
      </div>
      <script>
        $(function() {
          $('#mediaChooseSlide-<?php echo $slide->id ?>').rsMediaChooser({
            multiple: false,
            allowedMedia: [
              'picture'
            ],
            doneFunction: function (data) {
              $('#slider-<?php echo $slide->id ?>').val(data.id);
              $('#slider-name-<?php echo $slide->id ?>').val(data.name);
            }
          });
        });
      </script>


    </div>
    <br />
  <?php endforeach ?>
      <hr />
      <input type="submit" class="btn btn-primary" value="Save" />
    </form>
<?php } ?>
<?php function get_info_tab_content($item, $categories, $action) { ?>
    <br />
    <form class="form-horizontal" method="post" action="<?php echo $action ?>">
<div class="row">
  <div class="col-sm-5" style="padding:30px;">
      <!-- Text input-->
      <div class="form-group">
        <label class="control-label" for="name">Name</label>
          <input id="name" name="name" placeholder="Name" class="form-control input-md" type="text" value="<?php echo $item->name ?>">
          <span class="help-block">The name of the item</span>
      </div>

      <!-- Text input-->
      <div class="form-group">
          <label class="control-label" for="place">Place</label>
          <input id="place" name="place" placeholder="place" class="form-control input-md" type="text" value="<?php echo $item->place ?>">
      </div>

      <!-- Text input-->
      <div class="form-group">
        <label class="control-label" for="date">Date</label>
          <input id="date" name="dateItem" placeholder="Date" class="form-control input-md" type="text" value="<?php echo $item->dateItem ?>">
      </div>

      <!-- Select Basic -->
      <div class="form-group">
        <label class="control-label" for="category">Category</label>
          <select id="category" name="category" class="form-control">
            <?php foreach($categories as $c) : ?>
              <?php $selected = $c->id == $item->category->id ? 'selected' : '' ?>
              <option <?php echo $selected ?> value="<?php echo $c->id ?>"><?php echo $c->name ?></option>
            <?php endforeach ?>
          </select>
      </div>

      <!-- Appended Input-->
      <div class="form-group">
        <label class="control-label" for="thumbnail">Image Thumbnail</label>
          <div class="input-group">
            <?php
            $media = new Media($item->imageThumbnail);

            $name = $media->name;
            $id = $media->id;
            ?>
            <input value="<?php echo $name ?>" id="imageName" name="imageName" placeholder="Image" class="form-control input-md" type="text">
            <input value="<?php echo $id ?>" id="imageId" name="imageId" type="hidden">
            <span id="mediaChooseImage" class="input-group-addon btn btn-primary">Choisir</span>
          </div>
          <p class="help-block"> The image that is displayed in the list of items</p>
      </div>

      <!-- Button -->
      <div class="form-group">
          <button id="btnSave" name="btnSave" class="btn btn-primary">Save</button>
      </div>
  </div>
  <div class="col-sm-7" style="padding:30px;">
    <!-- Textarea
    <div class="form-group">
      <label class="control-label" for="hat">Hat</label>
      <textarea class="form-control summernote" id="hat" name="hat"> <?php echo $item->hat ?></textarea>
    </div> -->
    <div class="form-group">
      <label class="control-label" for="text">Text</label>
      <textarea class="form-control summernote" id="text" name="text"> <?php echo $item->text ?></textarea>
    </div>
  </div>
</div>
    </form>
<script>
  $(function() {
    $('#mediaChooseImage').rsMediaChooser({
      multiple: false,
      allowedMedia: [
        'picture'
      ],
      doneFunction: function (data) {
        $('#imageId').val(data.id);
        $('#imageName').val(data.name);
      }
    });
    omega.initSummerNote('.summernote');
  });
</script>
<?php } ?>
<?php function get_cp_tab_content($cpValues, $action) { ?>
  <br />
  <br />
  <form class="form-horizontal" action="<?php echo $action ?>&values_action=save" method="POST">
    <?php foreach($cpValues as $value) : ?>
      <div class="row">
        <div class="col-sm-8">
          <label><?php echo $value->property->title ?> :</label>
          <input value="<?php echo $value->value ?>" name="v[<?php echo $value->id ?>]" class="form-control" type="text">
        </div>
      </div>
      <br />
    <?php endforeach ?>
    <hr />
    <input type="submit" class="btn btn-primary" value="Save" />
  </form>
<?php } ?>

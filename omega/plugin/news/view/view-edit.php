<?php
use Omega\Library\Entity\Media;
?>
<?php echo $this->partialView('menu') ?>
<?php
$action = $this->getAdminLink('edit', array('id' => $_GET['id']));
?>

<form class="form-horizontal" action="<?php echo $action ?>" method="POST">

<div class="row">
  <div class="col-sm-8">
    <label class="control-label" for="title">Titre</label>
    <input value="<?php echo $item->title?>" id="title" name="title" placeholder="Titre" class="form-control input-md" type="text">
    <label class="control-label" for="text">Texte</label>
    <textarea class="summernote" id="text" name="text"><?php echo $item->text?></textarea>
    <p class="text-right"><br />
      <button id="btnSave" name="btnSave" class="btn btn-primary">Sauvegarder</button>
    </p>
  </div>

  <div class="col-sm-4">
    <label class="control-label" for="created">Date</label>
    <input value="<?php echo date('Y-m-d', strtotime($item->created)) ?>" id="created" name="created" placeholder="Date" class="form-control input-md" type="datetime">
    <label class="control-label" for="imageUrl">Image</label>
    <div class="input-group">
      <?php
      $media = new Media($item->idImage);

      $name = $media->name;
      $id = $media->id;
      $src = $media->path;
      ?>
      <div class="input-group">
        <input value="<?php echo $name ?>" id="imgLogoName" name="imgLogoName" placeholder="Image" class="form-control input-md" type="text">
        <input value="<?php echo $id ?>" id="imgLogo" name="idImage" type="hidden">
        <span id="mediaChooseLogo" class="input-group-addon btn btn-primary">Choisir</span>
      </div>
    </div>
    <p><img id="mediaChoosePreview" src="<?php echo ABSPATH . $src ?>" class="img-responsive img-thumbnail" /></p>
      <br />

      <label class="control-label" for="created">Catgories</label>
      <?php foreach($categories as $category) : ?>
      <div class="checkbox">
          <label>
              <?php
              $checked = '';
              foreach($postCategories as $npc){
                  if($npc->fkCategory == $category->id){
                      $checked = 'checked';
                      break;
                  }
              }
              ?>
              <input type="checkbox" <?php echo $checked ?> name="categories[]" value="<?php echo $category->id ?>"> <?php echo $category->name ?>
          </label>
      </div>
      <?php endforeach; ?>
  </div>
</div>
</form>

<script>
    $(function(){
        $('#mediaChooseLogo').rsMediaChooser({
            multiple: false,
            allowedMedia: [
                'picture'
            ],
            doneFunction: function(data){
                $('#imgLogo').val(data.id);
                $('#imgLogoName').val(data.name);
                $('#mediaChoosePreview').attr('src', data.path)
                console.log(data);
            }
        });
    });

    omega.initSummerNote('#text');
    omega.initSummerNote('#hat');
    omega.initDatePicker('#created');
</script>

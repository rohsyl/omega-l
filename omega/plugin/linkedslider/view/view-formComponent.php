<?php
use Omega\Library\Entity\Media;
?>
<table class="table table-condensed" id="<?php echo $this->fieldName('table') ?>">
    <tr>
        <th>Image/Video</th>
        <th>Lien</th>
        <!--<th>Titre</th>
        <th>Description</th>-->
        <th>
            <button id="<?php echo $this->fieldName('addSlide') ?>" class="btn btn-default btn-xs">Ajouter</button>
            <button id="<?php echo $this->fieldName('addVideo') ?>" class="btn btn-default btn-xs">Ajouter une video Youtube</button>
        </th>
    </tr>
    <?php foreach($slides as $sid => $slide) : ?>
        <?php if($slide['type'] == 'image'): ?>
        <?php
        $media = new Media($slide['slide']);
        $name = $media->name;
        $id = $media->id;
        ?>
        <tr id="<?php echo $this->fieldName('row-'.$sid) ?>">
            <td>
                <div class="input-group">
                    <input value="<?php echo $name ?>" id="<?php echo $this->fieldName('slide-name-'.$sid) ?>" placeholder="Image " class="form-control input-md" type="text">
                    <input value="<?php echo $id ?>" id="<?php echo $this->fieldName('slide-'.$sid) ?>" name="<?php echo $this->fieldName('slide') ?>[<?php echo $sid ?>]" type="hidden">
                    <span id="<?php echo $this->fieldName('slide-chooser-'.$sid) ?>" class="input-group-addon btn btn-primary">Choisir</span>
                </div>
                <script>
                    $(function() {
                        $('#<?php echo $this->fieldName('slide-chooser-'.$sid) ?>').rsMediaChooser({
                            multiple: false,
                            allowedMedia: [
                                'picture'
                            ],
                            doneFunction: function (data) {
                                $('#<?php echo $this->fieldName('slide-'.$sid) ?>').val(data.id);
                                $('#<?php echo $this->fieldName('slide-name-'.$sid) ?>').val(data.name);
                            }
                        });
                    });
                </script>
            </td>
            <td>
                <input type="text" class="form-control" name="<?php echo $this->fieldName('link') ?>[<?php echo $sid ?>]" value="<?php echo $slide['link'] ?>">
                <input type="hidden" class="form-control" name="<?php echo $this->fieldName('type') ?>[<?php echo $sid ?>]" value="image">
            </td>
            <!--<td>
                <input type="text" class="form-control" name="<?php echo $this->fieldName('title') ?>[<?php echo $sid ?>]" value="<?php echo $slide['title'] ?>">
            </td>
            <td>
                <input type="text" class="form-control" name="<?php echo $this->fieldName('descr') ?>[<?php echo $sid ?>]" value="<?php echo $slide['descr'] ?>">
            </td>-->
            <td>
                <button id="<?php echo $this->fieldName('deleteSlide') ?>" data-id="<?php echo $sid ?>" class="btn btn-danger">Supprimer</button>
            </td>
        </tr>
        <?php else: ?>
            <tr id="<?php echo $this->fieldName('row-'.$sid) ?>">
                <td colspan="2">
                    <input value="<?php echo $slide['url'] ?>" type="text" placeholder="Url Youtube" class="form-control" name="<?php echo $this->fieldName('url') ?>[<?php echo $sid ?>]">
                    <input type="hidden" class="form-control" name="<?php echo $this->fieldName('type') ?>[<?php echo $sid ?>]" value="video">
                </td>
                <!--<td>
                   <input type="text" class="form-control" name="<?php echo $this->fieldName('title') ?>[<?php echo $sid ?>]">
                </td>
                <td>
                    <input type="text" class="form-control" name="<?php echo $this->fieldName('descr') ?>[<?php echo $sid ?>]">
                </td>-->
                <td>
                    <button id="<?php echo $this->fieldName('deleteSlide') ?>" data-id="<?php echo $sid ?>" class="btn btn-danger">Supprimer</button>
                </td>
            </tr>
        <?php endif ?>
    <?php endforeach ?>
</table>

<script>
    $(function(){
        var btnAddSlide = $('#<?php echo $this->fieldName('addSlide') ?>');
        var btnAddVideo = $('#<?php echo $this->fieldName('addVideo') ?>');
        var btnDeleteSlide = '#<?php echo $this->fieldName('deleteSlide') ?>';
        var table = $('#<?php echo $this->fieldName('table') ?>');

        btnAddSlide.click(function(){
            var length = table.find('tr').length - 1;
            var data = '<tr id="<?php echo $this->fieldName('row') ?>-'+length+'">' +
                '<td>' +
                '<div class="input-group"> ' +
                '<input id="<?php echo $this->fieldName('slide-name') ?>-'+length+'" placeholder="Image " class="form-control input-md" type="text">' +
                '<input id="<?php echo $this->fieldName('slide') ?>-'+length+'" name="<?php echo $this->fieldName('slide') ?>['+length+']" type="hidden">' +
                '<span id="<?php echo $this->fieldName('slide-chooser') ?>-'+length+'" class="input-group-addon btn btn-primary">Choisir</span>' +
                '</div>' +
                '</td>' +
                '<td>' +
                '<input type="text" class="form-control" name="<?php echo $this->fieldName('link') ?>['+length+']">' +
                '<input type="hidden" class="form-control" name="<?php echo $this->fieldName('type') ?>['+length+']" value="image">' +
                '</td>' +
                //'<td>' +
                //'<input type="text" class="form-control" name="<?php echo $this->fieldName('title') ?>['+length+']">' +
                //'</td>' +
                //'<td>' +
                //'<input type="text" class="form-control" name="<?php echo $this->fieldName('descr') ?>['+length+']">' +
                //'</td>' +
                '<td>' +
                '<button id="<?php echo $this->fieldName('deleteSlide') ?>" data-id="'+length+'" class="btn btn-danger">Supprimer</button>' +
                '</td>' +
                '</tr>';
            table.append(data);
            $('#<?php echo $this->fieldName('slide-chooser') ?>-'+length).rsMediaChooser({
                multiple: false,
                allowedMedia: [
                    'picture'
                ],
                doneFunction: function (data) {
                    $('#<?php echo $this->fieldName('slide') ?>-'+length).val(data.id);
                    $('#<?php echo $this->fieldName('slide-name') ?>-'+length).val(data.name);
                }
            });
            return false;
        });

        btnAddVideo.click(function(){
            var length = table.find('tr').length - 1;
            var data = '<tr id="<?php echo $this->fieldName('row') ?>-'+length+'">' +
                '<td colspan="2">' +
                '<input type="text" placeholder="Url Youtube" class="form-control" name="<?php echo $this->fieldName('url') ?>['+length+']">' +
                '<input type="hidden" class="form-control" name="<?php echo $this->fieldName('type') ?>['+length+']" value="video">' +
                '</td>' +
                //'<td>' +
                //'<input type="text" class="form-control" name="<?php echo $this->fieldName('title') ?>['+length+']">' +
                //'</td>' +
                //'<td>' +
                //'<input type="text" class="form-control" name="<?php echo $this->fieldName('descr') ?>['+length+']">' +
                //'</td>' +
                '<td>' +
                '<button id="<?php echo $this->fieldName('deleteSlide') ?>" data-id="'+length+'" class="btn btn-danger">Supprimer</button>' +
                '</td>' +
                '</tr>';
            table.append(data);
            return false;
        });

        $( "body" ).delegate(btnDeleteSlide, 'click', function(){
            var id = $(this).data('id');
            var row = $('#<?php echo $this->fieldName('row') ?>-'+id);
            row.remove();
            return false;
        });
    });
</script>
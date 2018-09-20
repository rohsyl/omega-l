<div class="alert alert-info">
    Drag the different items up or down below to set how they should be arranged.<br/>
    And click on the "Save" button to validate.
</div>
<table class="sortable table">
    <?php foreach($properties as $property) : ?>
    <tr data-idprop="<?php echo $property->id ?>">
        <td><?php echo $property->title ?></td>
    </tr>
    <?php endforeach ?>
</table>

<script>
    $(function(){
        $('td, th', '.sortable').each(function () {
            var cell = $(this);
            cell.width(cell.width());
            cell.css('background-color', '#ffffff');
        });
        $( '.sortable tbody' ).sortable({
            containerSelector: 'table',
            itemPath: '> tbody',
            itemSelector: 'tr',
            helper: function(e, tr)
            {
                var $originals = tr.children();
                var $helper = tr.clone();
                $helper.children().each(function(index)
                {
                    // Set helper cell sizes to match the original sizes
                    $(this).width($originals.eq(index).width());
                });
                return $helper;
            },
            placeholder: 'sortable-placeholder'
        }).disableSelection();
    });
</script>
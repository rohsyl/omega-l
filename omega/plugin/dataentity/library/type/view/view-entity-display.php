<div>
    <p id="text-<?php echo $uid ?>"><?php echo $text ?></p>
    <button class="btn btn-default" id="btnChooseEntity-<?php echo $uid ?>">Choose a <?php echo $entity->title ?></button>
    <input type="hidden" id="<?php echo $uid ?>" name="<?php echo $uid ?>" value="<?php echo $value ?>" class="form-control" />
</div>

<script lang="javascript">
    $(function(){
        var entityId = <?php echo $entity->id ?>;
        var body = $('body');
        var btn = $('#btnChooseEntity-<?php echo $uid ?>');
        var btnChooseEntity = '.button-choose-entity-<?php echo $uid ?>';
        var input = '#<?php echo $uid ?>';
        var text = '#text-<?php echo $uid ?>';

        var modalChooseEntityId = undefined;
        btn.click(function(e){
            e.preventDefault();
            var url = omega.plugin.mvc.url('dataentity', 'getEntityInstanceList', {entityId : entityId});
            omega.ajax.query(url, {}, omega.ajax.GET, function(json){

                var html = buildHtmlEntityList(json);

                modalChooseEntityId = omega.modal.open(__('Choose a <?php echo $entity->title ?>'), html, undefined, undefined);


            }, undefined, {dataType: 'json'});
            return false;
        });
        body.on('click', btnChooseEntity, function(e){
            if(typeof modalChooseEntityId !== 'undefined'){

                var entityId = $(this).data('id');

                $(input).val(entityId);
                $(text).html($(this).html());

                omega.modal.hide(modalChooseEntityId);
                modalChooseEntityId = undefined;


            }
        });

        function buildHtmlEntityList(json){
            var html = '<div class="list-group">';

            for(var i = 0; i < json.length; i++){
                html += '<button type="button" class="list-group-item button-choose-entity-<?php echo $uid ?>" data-id="'+json[i].id+'">';
                for(var property in json[i].data){
                    html += json[i].data[property] + ' ';
                }
                html += '</button>';
            }
            html += '</div>';
            return html;
        }

    });
</script>
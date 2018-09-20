<div id="entity-browser-container">

</div>
<script lang="javascript">
    $(function(){
        var $container = $('#entity-browser-container');
        var $body = $('body');
        var cEntityItem = '.entity-item';
        var cEntityItemData = '.entity-item-data';

        loadEntities();

        function loadEntities(){
            var url = omega.plugin.mvc.url('dataentity', 'entitiesList');
            omega.ajax.query(url, {}, omega.ajax.GET, function(html){
                $container.html(html);
            });
        }

        function loadEntityInstances(id){
            var url = omega.plugin.mvc.url('dataentity', 'dataInstancesList', {idEntity : id});
            omega.ajax.query(url, {}, omega.ajax.GET, function(html){
                $container.html(html);
            });
        }

        $body.off('click', cEntityItem);
        $body.on('click', cEntityItem, function(){
            var id = $(this).data('id');
            loadEntityInstances(id);
        });

        $body.off('click', cEntityItemData);
        $body.on('click', cEntityItemData, function(){
            console.log('xolo');
           $(this).toggleClass('selected').blur();
        });
    });
</script>
<div>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#internal" aria-controls="internal" role="tab" data-toggle="tab">Internal</a></li>
        <li role="presentation"><a href="#media" aria-controls="media" role="tab" data-toggle="tab">Media</a></li>
        <li role="presentation"><a href="#external" aria-controls="external" role="tab" data-toggle="tab">External</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="internal">
            <br />
            <label class="control-label">Pages</label>
            <table class="table table-hover linkchooser-table-pages">
            @foreach($pages as $page)
                <tr data-id="{{ $page->id }}" data-name="{{ $page->name }}" class="active">
                    <td>{{ $page->name }}</td>
                    <td><button class="linkchooser-btn-toggle-comp btn btn-default btn-xs" data-visible="false" data-id="{{ $page->id }}"><i class="fa fa-angle-down"></i></button></td>
                </tr>
                @if(!empty($page->components)) 
                    @foreach($page->components as $comp) 
                        @php
                        $args = json_decode($comp->param, true);
                        @endphp
                    <tr class="linkchooser-page-comp linkchooser-page-comp-{{ $page->id }}"
                        data-id="{{ $page->id }}"
                        data-name="{{ $page->name }}"
                        data-comp="{{ $args['settings']['compId'] }}">
                        <td><i class="fa fa-hashtag"></i> {{ $args['settings']['compId'] }}</td>
                        <td></td>
                    </tr>
                    @endforeach
                @endif
            @endforeach
            </table>
        </div>
        <div role="tabpanel" class="tab-pane" id="media">
            <br />
            <label class="control-label">Medias</label>
            <br />
            <br />
            <div class="linkchooser-bc-medias"></div>
            <div class="linkchooser-tablecont-medias"></div>
        </div>
        <div role="tabpanel" class="tab-pane" id="external">
            <br />
            <label class="control-label" for="linkchooser-external-input">Link</label>
            <input class="form-control linkchooser-external-input" type="text" id="linkchooser-external-input" />
            <br />
        </div>
    </div>
    <hr />
    <p class="linkchooser-choosed well"></p>
    <input type="hidden" class="linkchooser-input">
</div>
<script>
    $(function () {

        // INTERNAL
        $('.linkchooser-table-pages tr').click(function(e){
            var id = $(this).data('id');
            var name = $(this).data('name');
            var isComp = $(this).hasClass('linkchooser-page-comp');

            if(isComp){
                var comp = $(this).data('comp');

                $('.linkchooser-choosed').html(name+ "#" + comp);

                var data = {
                    type: 'internal',
                    idPage : id,
                    section: comp,
                    text: 'Internal:'+name+'#'+comp
                };
            }
            else{
                $('.linkchooser-choosed').html(name);

                var data = {
                    type: 'internal',
                    idPage : id,
                    section: undefined,
                    text: 'Internal:'+name
                };
            }

            $('.linkchooser-input').val(encodeURIComponent(JSON.stringify(data)));
        });
        $('.linkchooser-btn-toggle-comp').click(function(e){
            e.stopPropagation();

            var isVisible = $(this).data('visible');
            var id = $(this).data('id');
            var classChild = '.linkchooser-page-comp-'+id;
            if(!isVisible){
                $(classChild).show();
                $(this).html('<i class="fa fa-angle-up"></i>');
                isVisible = true;
            }
            else{
                $(classChild).hide();
                $(this).html('<i class="fa fa-angle-down"></i>');
                isVisible = false;
            }$(this).data('visible', isVisible);
        });
        // END INTERNAL

        // EXTERNAL
        $('.linkchooser-external-input').change(function(e){
            var value = $(this).val();
            var data = {
                type: 'external',
                link : value,
                text: 'External:'+value
            };
            $('.linkchooser-choosed').html(data.text);
            $('.linkchooser-input').val(encodeURIComponent(JSON.stringify(data)));
        });
        //END EXTERNAL

        // MEDIA
        mediaIdRoot = {{ $mediaIdParent }};
        mediaIdParent = mediaIdRoot;

        function loadBreadcrumb(){
            var url = route('linkchooser.bc', { id : mediaIdParent});
            omega.ajax.query(url, {}, omega.ajax.GET, function(json){
                var home = [{id: mediaIdRoot, name: '<i class="fa fa-home"></i>'}];
                var data = home.concat(json.bc);

                var html = '<ol class="breadcrumb linkchooser-bc">';
                for(var i = 0; i < data.length; i++){
                html += '<li><a href="#" data-id="'+data[i]['id']+'">'+data[i]['name']+'</a></li>'
                }
                html += '</ol>';
                $('.linkchooser-bc-medias').html(html);
            }, undefined, {dataType: 'json'});
        }
        function loadDirectory(){
            var url = route('linkchooser.dc', { id : mediaIdParent});
            omega.ajax.query(url, {}, omega.ajax.GET, function(html){
                $('.linkchooser-tablecont-medias').html(html);
            });
            loadBreadcrumb();
        }

        $( "body" ).delegate( ".linkchooser-table-medias tr", "click", function() {
            var type = $(this).data('type');
            var name = $(this).data('name');
            var id = $(this).data('id');
            if(type != 1 ){

                $('.linkchooser-choosed').html(name);

                var data = {
                    type: 'media',
                    idMedia : id,
                    text: 'Media:'+name
                };

                $('.linkchooser-input').val(encodeURIComponent(JSON.stringify(data)));
            }
            mediaIdParent = id;
            loadDirectory();
        });
        $( "body" ).delegate( ".linkchooser-bc a", "click", function() {
            mediaIdParent = $(this).data('id');
            loadDirectory();
        });

        loadDirectory();
        // END MEDIA
    });
</script>
<style>
    .linkchooser-table-pages tr{
        cursor: pointer;
    }

    .linkchooser-page-comp{
        display: none;
    }

    .linkchooser-btn-toggle-comp{
        float:right;
    }

    .linkchooser-tablecont-medias .list-media{
        max-height: 340px;
        overflow-y: auto;
    }
    .linkchooser-table-medias tr{
        cursor: pointer;
    }
</style>
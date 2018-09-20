<?php echo $this->partialView('menu');
$action = $this->getAdminLink('customProperties');
?>
<a href="<?php echo $action ?>&cp=new" class="btn btn-default" >Create new custom properties</a>
<a href="#" class="btn btn-default" id="portfolio-cp-order" >Order properties</a>
<br />
<br />
<form class="form-horizontal" action="<?php echo $action ?>&cp=save" method="POST">
    <?php echo $this->partialView('customProperties-table', array('properties' => $properties)); ?>
    <input type="submit" class="btn btn-primary" value="Save" />
</form>
<script>
    $(function () {
        var $btnOrder = $('#portfolio-cp-order');
        var $container = $('#portfolio-cp-viewTable');

        $btnOrder.click(function(){
            var url = omega.plugin.mvc.url('portfolio', 'formOrder');
            omega.ajax.query(url, {}, 'GET', function(html){
                var mid = omega.modal.open('Order properties', html, 'Save', function(){
                    var array = new Array();
                    $('.sortable > tbody  > tr').each(function(i) {
                        var id = $(this).data('idprop');
                        array.push({order: i, id: id});
                    });
                    var url = omega.plugin.mvc.url('portfolio', 'saveOrder');
                    omega.ajax.query(url, {order:array}, 'POST', function(){
                        omega.modal.hide(mid);
                        url = omega.plugin.mvc.url('portfolio', 'cpTable');
                        omega.ajax.query(url, {}, 'GET', function(html) {
                            $container.html(html);
                            $.growl.notice({title:'Success',message:'Custom properties order saved !'})
                        });
                    });
                });
            });
        });
    });
</script>
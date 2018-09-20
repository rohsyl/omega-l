<?php
use Omega\Library\Util\Util;
?>
<div class="filter-list">
    <ul>
        <?php foreach($filterCategories as $c) : ?>
            <li>
            <span class="filter-btn category" data-value="<?php echo Util::SlugifyText($c->name) ?>">
                <?php echo $c->name ?>
            </span>
            </li>
        <?php endforeach ?>
    </ul>
</div>
<script>
    $(function(){

        $items = $('.link-item');
        $buttons = $('.filter-btn');
        $buttons.click(function(){

            if($(this).hasClass('category') && !$(this).hasClass('active')) {
                $('.filter-btn.category').removeClass('active');
            }
            if($(this).hasClass('place') && !$(this).hasClass('active')) {
                $('.filter-btn.place').removeClass('active');
            }
            if($(this).hasClass('date') && !$(this).hasClass('active')) {
                $('.filter-btn.date').removeClass('active');
            }

            if($(this).hasClass('active'))
            {
                $(this).removeClass('active');
            }
            else
            {
                $(this).addClass('active');
            }
            applyFilter();
        });

        function applyFilter()
        {
            var filters = [];
            $('.filter-btn.active').each(function(){
                filters.push($(this).data('value').toString())
            });

            $items.each(function(){
                var values = $(this).data('filter').split(',');
                var hasValue = false;
                if(filters.length == 0)
                {
                    hasValue = true;
                }
                else
                {
                    for (var i = 0; i < filters.length; i++)
                    {
                        if (values.indexOf(filters[i]) == -1)
                        {
                            hasValue = false;
                        }
                        else
                        {
                            hasValue = true;
                        }
                        if (!hasValue) break;
                    }
                }
                if(!hasValue)
                {
                    $(this).hide(300);
                }
                else
                {
                    $(this).show(300);
                }
            });
        }
    });
</script>

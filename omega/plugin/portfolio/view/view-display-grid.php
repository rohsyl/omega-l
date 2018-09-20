<?php echo $this->partialView('display-filter', $m) ?>

<?php
use Omega\Library\Util\Util;

$col = 12 / $gridSize;

?>

<div class="filter-items">
    <div class="row">
        <?php foreach($items as $item) : ?>
        <div class="col-sm-<?php echo $col ?> link-item"
             data-filter="<?php echo Util::SlugifyText($item->category->name) ?>,<?php echo Util::SlugifyText($item->place) ?>,<?php echo $item->dateItem ?>"
            >
            <a href="?item=<?php echo $item->id ?>">
                <div class="item item-width-<?php echo $col ?>" style="border-color: <?php echo $item->category->color ?>;">
                    <?php
                    $w = 265;
                    $h = 180;
                    if($col == 4){
                        $w = 360;
                        $h = 250;
                    }
                    if($col == 6){
                        $w = 550;
                        $h = 350;
                    }
                    ?>
                    <div class="item-image" style="background-image: url('<?php echo $item->image->GetThumbnail($w, $h) ?>');">
                    </div>
                    <div class="item-hover">
                        <span class="name"><?php echo $item->name ?></span>
                        <span class="category"><?php echo $item->category->name ?></span>
                    </div>
                </div>
            </a>
        </div>
        <?php endforeach ?>
    </div>
</div>



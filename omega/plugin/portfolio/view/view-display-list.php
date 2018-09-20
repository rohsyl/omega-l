<?php
$count = count($items);
$i = 0;
?>
<?php foreach($items as $item) : ?>
<div class="row portfolio-list-item">
    <div class="col-md-4">
        <div class="portfolio-list-item-image">
            <a href="?item=<?php echo $item->id ?>">
                <img class="img-responsive" src="<?php echo $item->imageThumbnail->GetThumbnail(500, 500) ?>" alt="" width="100%">
                <div class="portfolio-list-item-link">
                    <i class="fa fa-plus fa-2x"></i>
                </div>
            </a>
        </div>
    </div>
    <div class="col-md-8">
        <h3><?php echo $item->name ?></h3>
        <h4><i class="fa fa-circle" style="color:<?php echo $item->category->color ?>"></i> <?php echo $item->category->name ?></h4>
        <p><?php echo $item->hat ?></p>
        <a class="btn btn-default portfolio-list-item-seemore" href="?item=<?php echo $item->id ?>">En savoir plus <span class="glyphicon glyphicon-chevron-right"></span></a>
    </div>
</div>
<?php
if($count - 1 > $i)
    echo '<hr />';
$i++;
?>
<?php endforeach ?>

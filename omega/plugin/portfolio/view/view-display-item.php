<?php
    use Omega\Library\Entity\Media;
?>

<?php
$url = strtok($_SERVER["REQUEST_URI"],'?');
?>
<div class="article">
    <a class="article-back-to" title="Back to list" href="<?php echo $url ?>"><span class="fa fa-th"></span></a>
    <h1 class="article-title"><?php echo $item->name ?> <small><?php echo $item->category->name ?></small></h1>
    <br />
    <!-- Carousel -->
    <?php
        $carouselHeight = 400;
    ?>
    <?php if(sizeof($item->slides) > 0) : ?>
        <div class="owl-carousel">
        <?php foreach($item->slides as $slide) : ?>
            <?php
                $x = new Media($slide->fkMedia);
                $imageWidth = $x->getWidth();
                $imageHeight = $x->getHeight();
                $thumbnailWidth = round($carouselHeight / $imageHeight * $imageWidth);
            ?>
            <div class="item">
                <picture>
                    <source srcset="<?php echo $x->GetThumbnail($carouselHeight, $carouselHeight) ?>" media="(max-width: 768px)">
                    <img src="<?php echo $x->GetThumbnail($thumbnailWidth, $carouselHeight) ?>" />
                </picture>
                <?php if($imageZoom): ?>
                    <a class="btn-zoom" href="<?php echo $x->path ?>" target="_blank"><i class="fa fa-search-plus"></i></a>
                <?php endif ?>
            </div>
        <?php endforeach ?>
        </div>
    <?php endif ?>
    <!--End Carousel-->
    <div class="row article-description">
        <div class="col-md-4 col-sm-12">
            <div class="article-description-meta">
                <table class="table-portfolio">
                    <tr>
                        <th>Année :</th>
                        <td><?php echo $item->dateItem ?></td>
                    </tr>
                <?php foreach($item->properties as $property) : ?>
                    <?php if(!empty($property['value'])) : ?>
                        <tr>
                            <th><?php echo $property['title'] ?> :</th>
                            <td><?php echo $property['value'] ?></td>
                        </tr>
                    <?php endif ?>
                <?php endforeach ?>
                </table>
            </div>
        </div>
        <div class="col-md-8 meta-description">
                <?php echo $item->text ?>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('.owl-carousel').owlCarousel({
            <?php echo $owlNav ? 'nav : true, ' : '' ?>
            margin:10,
            navText : ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
            dots: false,
            responsive : {
                // breakpoint from 0 up
                0 : {
                    autoWidth : false,
                    loop : false,
                    items : 1
                },
                // breakpoint from 768 up
                768 : {
                    autoWidth : true,
                    loop : true,
                    items : 1
                }
            }
        });
    });
</script>
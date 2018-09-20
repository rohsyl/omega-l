<?php
    use function Omega\Library\oo;
?>

<?php if(isset($file)) : ?>
    <div class="embed-responsive embed-responsive-4by3">
    <object data="<?php echo $file->path ?>" type="application/pdf" width="100%" height="<?php echo isset($height) && !empty($height) ? $height : '800' ?>px">
        <p>It appears you don't have a PDF plugin for this browser.
            No biggie... you can <a href="<?php echo $file->path ?>">click here to
                download the PDF file.</a></p>
    </object>
    </div>
    <p><?php oo('Download the') ?> <a href="<?php echo $file->path ?>"><?php oo('file') ?></a>.</p>
<?php endif ?>
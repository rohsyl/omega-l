<?php if(isset($enabledAnalytics) && $enabledAnalytics && isset($id) && !empty($id)) : ?>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $id ?>"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', '<?php echo $id ?>');
</script>
<?php endif ?>
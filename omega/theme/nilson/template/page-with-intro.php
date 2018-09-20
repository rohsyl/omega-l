<body>

<div class="landing">
    <div class="landing-logo"></div>
</div>
<script>

    function isIE() {
        var ua = window.navigator.userAgent;

        var msie = ua.indexOf('MSIE ');
        if (msie > 0) {
            // IE 10 or older => return version number
            return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
        }

        var trident = ua.indexOf('Trident/');
        if (trident > 0) {
            // IE 11 => return version number
            var rv = ua.indexOf('rv:');
            return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
        }

        var edge = ua.indexOf('Edge/');
        if (edge > 0) {
            // Edge (IE 12+) => return version number
            return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
        }

        // other browser
        return false;
    }
    $(function(){
        //if(!isIE()) {
            $('.landing-logo').fadeIn(500);
            $('.landing').delay(1500).fadeOut(1000);
       // }
        //else{
        //    $('.landing').remove();
        //}
    });
</script>
<style>
    .landing{
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: #fff;
        z-index: 100;
    }
    .landing-logo{
        display: none;
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-position: center center;
        background-size: 500px;
        background-repeat: no-repeat;
        background-image: url("<?php echo $site->template_directory_uri ?>/images/logo.svg");
        z-index: 101;
    }
    @media all and (max-width: 500px) {
        .landing-logo
        {
            background-size: 90% auto;
        }
    }
</style>

<div id="header-wrapper">
    <a href="#menu-mobile" class="menu-mobile-toggle hidden-md hidden-lg"><i class="fa fa-bars"></i></a>
    <div id="header" class="container">
        <div id="logo">
            <a href="<?php echo UrlHelper::Absolute(ABSPATH) ?>">
                <img src="<?php echo $site->template_directory_uri ?>/images/logo.svg" alt="<?php echo $site->name ?>" />
            </a>
        </div>
        <div id="menu" class="hidden-sm hidden-xs">
            <?php echo $menu->getBySecurity(); ?>
            <!--<ul>
                <li class="active"><a href="index.html" title="">Accueil</a></li>
                <li><a href="bureau.html" title="">Bureau</a></li>
                <li><a href="projets.html" title="">Projets</a></li>
                <li><a href="contact.html" title="">Contact</a></li>
            </ul>-->
        </div>
    </div>
</div>
<div class="wrapper-x">
    <?php echo $page->content ?>
</div>
<nav id="menu-mobile" class="hidden-md hidden-lg">
    <?php echo $menu->getBySecurity(); ?>
</nav>
<?php include($site->php_template_path . '/footer.php'); ?>
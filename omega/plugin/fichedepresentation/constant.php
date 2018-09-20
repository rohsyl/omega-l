<?php
if(!defined('FICHE_DE_PRES_CONST'))
{
    define('FICHE_DE_PRES_CONST', 'fdpconst');

    define('TABLE_SECTION', 'alb_section');
    define('SEC_ID', 'id');
    define('SEC_NAME_S', 'name_simple');
    define('SEC_NAME_F', 'name_full');
    define('SEC_IMG', 'image');
    define('SEC_ORDER', 'reaOrder');
    define('SEC_DESCR', 'description');

    define('TABLE_ALB', 'alb_album');
    define('ALB_ID', 'id');
    define('ALB_NAME', 'name');
    define('ALB_YEAR', 'date');
    define('ALB_SEC', 'fkSection');

    define('TABLE_IMG', 'alb_image');
    define('IMG_ID', 'id');
    define('IMG_MEDIA', 'fkMedia');
    define('IMG_ALBUM', 'fkAlbum');
    define('IMG_ORDER', 'imgOrder');

    define('CFG_BIMG_W', 'big_image_width');
    define('CFG_BIMG_H', 'big_image_height');
    define('CFG_COPY_EN', 'copyright_enable');
    define('CFG_COPY_IMG', 'copyright_image');
    define('CFG_COPY_W', 'copyright_width');
    define('CFG_COPY_H', 'copyright_height');
    define('CFG_COPY_X', 'copyright_x');
    define('CFG_COPY_Y', 'copyright_y');
    define('CFG_THUMB_W', 'thumbnail_width');
    define('CFG_THUMB_H', 'thumbnail_height');
}


if(!function_exists('e')){
    function e($v){
        echo isset($v) ? $v : '';
    }
}
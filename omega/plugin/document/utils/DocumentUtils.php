<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 09.11.18
 * Time: 17:44
 */

namespace OmegaPlugin\document\utils;


class DocumentUtils
{

    public static function getIconByExt($ext) {
        switch ($ext)
        {
            case 'xlsx':
            case 'xls':
                return 'fa fa-file-excel-o';
                break;
            case 'doc':
            case 'docx':
                return 'fa fa-file-word-o';
                break;
            case 'ppt':
            case 'pptx':
                return 'fa fa-file-powerpoint-o';
                break;
            case 'pdf':
                return 'fa fa-file-pdf-o';
                break;
            case 'jpg':
            case 'jpeg':
            case 'gif':
            case 'png':
                return 'fa fa-file-image-o';
                break;
            default:
                return 'fa fa-file-o';
                break;
        }
    }

    public static function getClassByExt($ext, $type = '') {
        switch ($ext) {
            case 'xlsx':
            case 'xls':
                return 'document-type excel';
                break;
            case 'doc':
            case 'docx':
                return 'document-type word';
                break;
            case 'ppt':
            case 'pptx':
                return 'document-type powerpoint';
                break;
            case 'pdf':
                return 'document-type adobe';
                break;
            case 'jpg':
            case 'jpeg':
            case 'gif':
            case 'png':
                return 'document-type image';
                break;
            default:
                return 'document-type file';
                break;
        }
    }

    public static function compare_order($a, $b) {
        if ($a['order'] == $b['order']) return 0;
        return ($a['order'] < $b['order']) ? -1 : 1;
    }

    public static function formatBytes($bytes, $precision = 2) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        // Uncomment one of the following alternatives
        // $bytes /= pow(1024, $pow);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
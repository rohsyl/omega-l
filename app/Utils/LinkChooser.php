<?php
namespace Omega\Utils;

use Omega\Utils\Entity\Page;
use Omega\Utils\Entity\Media;
use Omega\Utils\Url;

class LinkChooser{

    public static function Encode($value){
        //Encode before display in the html page
        return urlencode($value);
    }

    public static function Decode($value){
        //Decode before saving in database
        return urldecode($value);
    }

    public static function GetLink($value, $param = null){
        if(isset($value)){
            $data = json_decode(self::Decode($value), true);

            switch($data['type']){
                case 'internal':
                    $id = $data['idPage'];
                    $link =  Page::GetUrl($id);
                    return Url::Link(
                        $link,
                        isset($param) ? $param : null,
                        isset($data['section']) ? $data['section'] : null
                    );
                    break;
                case 'external':
                    return $data['link'];
                    break;
                case 'media':
                    $id = $data['idMedia'];
                    $media = Media::Get($id);
                    if($media->getType() == Media::T_VIDEO_EXT){
                        return $media->path;
                    }
                    $link = Url::CombAndAbs(url('/'), $media->path);
                    return $link;
                    break;
            }
        }
        return ABSPATH;
    }
}
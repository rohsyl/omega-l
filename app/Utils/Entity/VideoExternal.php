<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 13.09.2017
 * Time: 12:35
 */

namespace Omega\Utils\Entity;



use Omega\Utils\Path;
use Omega\Utils\Url;

class VideoExternal
{

    const TYPE_YOUTUBE = 'youtube';
    const TYPE_VIMEO = 'vimeo';

    private $plateform;
    private $videoId;

    private $media;

    public function __construct($media, $loadMeta = false)
    {
        $this->media = $media;
        if ($this->media->exists) {
            $this->readUrl();
            if($loadMeta){
                $this->fetchDetail();
            }
        }
    }

    public function readUrl(){
        $url = $this->path;
        if($this->is(self::TYPE_YOUTUBE, $url)){
            $queryString = parse_url($url, PHP_URL_QUERY);
            parse_str($queryString, $params);
            $this->videoId = $params['v'];
            $this->plateform = self::TYPE_YOUTUBE;
        } else if ($this->is(self::TYPE_VIMEO, $url)) {
            $urlParts = explode("/", parse_url($url, PHP_URL_PATH));
            $this->videoId = (int)$urlParts[count($urlParts)-1];
            $this->plateform = self::TYPE_VIMEO;
        }
    }

    public function getPlateform(){
        return $this->plateform;
    }

    public function getVideoId(){
        return $this->videoId;
    }

    private function is($type, $url)
    {
        switch($type) {
            case self::TYPE_YOUTUBE:
                $parse = parse_url($url);
                $host = $parse['host'];
                if (strpos($host, 'youtube') !== false ||
                    strpos($host, 'youtu') !== false)
                    return true;
                break;
            case self::TYPE_VIMEO:
                $parse = parse_url($url);
                $host = $parse['host'];
                if (strpos($host, 'vimeo') !== false)
                    return true;
                break;
        }
        return false;
    }

    public function fetchDetail(){
        $videoId = $this->getVideoId();
        $title = '';
        $description = '';
        $thumbnail = null;
        if($this->getPlateform() == self::TYPE_VIMEO){
            $hash = json_decode(file_get_contents("http://vimeo.com/api/v2/video/{$videoId}.json"));
            $title = $hash[0]->title;
            $description = $hash[0]->description;
            $thumbnail = $hash[0]->thumbnail_large;
        }
        else if($this->getPlateform() == self::TYPE_YOUTUBE){
            /*$hash = json_decode(file_get_contents("http://gdata.youtube.com/feeds/api/videos/{$videoId}?v=2&alt=json"));
            $title = $hash->data->title;
            $description = $hash->data->description;
            $thumbnail = $hash->data->thumbnail->hqDefault;*/
            // TODO : get youtube meta of video
            $title = 'Youtube ' . $this->getVideoId();
        }

        if(isset($thumbnail)){
            $path_parts = pathinfo(parse_url($thumbnail, PHP_URL_PATH));
            $ext = $path_parts['extension'];

            $mediaFolder = Path::Combine(public_path('media'), $this->id);
            if(!file_exists($mediaFolder)){
                Path::MkDir($mediaFolder);
            }
            $destPath = Path::Combine($mediaFolder, $this->id.'.'.$ext);

            file_put_contents($destPath, file_get_contents($thumbnail));
            $this->ext = $ext;
        }

        $this->media->name = $title;
        $this->media->title = $title;
        $this->media->description = $description;
        $this->media->save();
    }

    public function setVideoThumbnail($mediaId){
        $media = new Media($mediaId);
        $sourcePath = $media->getRealpath();

        $path_parts = pathinfo($sourcePath);
        $ext = $path_parts['extension'];

        $mediaFolder = Path::Combine(public_path('media'), $this->id);

        if(!file_exists($mediaFolder)){
            Path::MkDir($mediaFolder);
        }

        $destPath = Path::Combine($mediaFolder, $this->id.'.'.$ext);

        $ret = copy($sourcePath, $destPath);

        if($ret){
            $this->media->ext = $ext;
            $this->media->save();
        }
        return $ret;
    }

    public function getVideoThumbnail(){
        if(!isset($this->ext) && empty($this->ext))
            return null;
        return Url::CombAndAbs(url('/'), 'media', $this->id, $this->id.'.'.$this->ext);
    }
}
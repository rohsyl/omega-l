<?php

namespace Omega\Models;

use Illuminate\Database\Eloquent\Model;
use Omega\Repositories\MediaMetaRepository;
use Omega\Repositories\MediaRepository;
use Omega\Utils\Entity\Entity;
use Omega\Utils\Interfaces\InterfaceMediaConstant;
use Omega\Utils\Url;

class Media extends Model implements InterfaceMediaConstant
{

    protected $table = 'medias';

    private static $mediaRepository;
    private static $mediaMetaRepository;

    /**
     * Get an instance of MediaRepository
     * @return MediaRepository
     */
    private static function GetMediaRepository(){
        if(!isset(self::$mediaRepository)){
            self::$mediaRepository = new MediaRepository(new Media());
        }
        return self::$mediaRepository;
    }

    /**
     * Get an instance of MediametaRepository
     * @return MediaMetaRepository
     */
    private static function GetMediaMetaRepository(){
        if(!isset(self::$mediaMetaRepository)){
            self::$mediaMetaRepository = new MediaMetaRepository(new MediaMeta());
        }
        return self::$mediaMetaRepository;
    }

    /**
     * Get a media by id
     * @param $id int The Id
     * @return Media The media
     */
    public static function Get($id){
        return self::GetMediaRepository()->GetMedia($id);
    }

    private $metas = array();


    public function getTitle($lang = null){
        return $this->getMeta($lang, 'title');
    }

    public function getDescription($lang = null){
        return $this->getMeta($lang, 'description');
    }

    public function setTitle($title, $lang = null){
        $this->setMeta($lang, 'title', $title);
    }

    public function setDescription($description, $lang = null){
        $this->setMeta($lang, 'description', $description);
    }

    private function getMeta($lang, $meta) {
        if(!isset($lang)){
            // get active lang
            $lang = Entity::LangSlug();
        }
        if(array_key_exists($lang, $this->metas)){
            $l = $this->metas[$lang];
            if(array_key_exists($meta, $l)){
                return $l[$meta];
            }
        }
        return '';
    }

    private function setMeta($lang, $meta, $value){
        if(!isset($lang)){
            // get active lang
            $lang = Entity::LangSlug();
        }
        $this->metas[$lang][$meta] = $value;
    }

    public function readInDbMeta(){
        $metas = self::GetMediametaRepository()->GetAllForMedia($this->id);
        $this->metas = array();
        foreach($metas as $meta){
            $this->metas[$meta->lang] = array(
                'id' => $meta->id,
                'title' => $meta->title,
                'description' => $meta->description
            );
        }
    }


    public function saveMeta(){
        foreach($this->metas as $lang => $meta) {
            $mm = self::GetMediaMetaRepository()->getOrNew(isset($meta['id']) ? $meta['id'] : null);
            $mm->lang = $lang;
            $mm->title = $meta['title'];
            $mm->description = $meta['description'];
            $mm->fkMedia = $this->id;
            $mm->save();
            $this->metas[$lang]['id'] = $mm->id;
        }
    }

    /*
    public function GetThumbnail($w, $h, $returnUrl = true)
    {

        $fn = basename($this->path);
        $p = Path::Combine(ROOT, 'media', $this->id);
        $fp = Path::Combine($p, $fn);

        $newFilename = PictureHelper::GetImageName($fp, $w, $h);
        $newFilePath = Path::Combine( $p, $newFilename);
        $newFileUrl = Url::Absolute(Url::Combine( ABSPATH, 'media', $this->id, $newFilename));

        if(!file_exists($newFilePath))
            PictureHelper::Crop($fp, $newFilePath, $w, $h, 100);

        return $returnUrl ? $newFileUrl : $newFilePath;
    }*/

    public function getType(){
        return $this->getTypeByExt($this->ext);
    }

    public function getWidth()
    {
        if($this->getType() != self::T_PICTURE){
            return 0;
        }
        list($width) = getimagesize($this->getRealpath());
        return $width;
    }

    public function getHeight()
    {
        if($this->getType() != self::T_PICTURE){
            return 0;
        }
        list($width, $height) = getimagesize($this->getRealpath());
        return $height;
    }



    public function __toString()
    {
        return '<a href="'.Url::CombAndAbs(url('/'), $this->path).'", target="_blank">Preview</a>';
    }


    public function getFilesize()
    {
        return self::GetMediaRepository()->GetMediaSize($this);
    }

    public function getRealpath()
    {
        return self::GetMediaRepository()->GetRealpath($this);
    }

    public function getChildren($filterType = null){

        $medias = self::GetMediaRepository()->GetMedias($this->id);
        $m = array();
        foreach($medias as $media){
            if($filterType == null || (isset($filterType) && in_array($media->getType(), $filterType))){
                $m[] = $media;
            }
        }
        return $m;
    }

    private function getTypeByExt($ext){
        return self::GetMediaRepository()->GetType($this);
    }
}

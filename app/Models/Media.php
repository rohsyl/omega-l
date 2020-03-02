<?php

namespace Omega\Models;

use Illuminate\Database\Eloquent\Model;
use Omega\Repositories\MediaMetaRepository;
use Omega\Repositories\MediaRepository;
use Omega\Facades\Entity;
use Omega\Utils\Interfaces\InterfaceMediaConstant;
use Omega\Utils\Path;
use Omega\Utils\PictureHelper;
use Omega\Utils\Url;

class Media extends Model implements InterfaceMediaConstant
{
    const IMG_404 = 'images/image-not-found.png';

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

        /*
        public function __construct(array $attributes = [])
        {
            parent::__construct($attributes);

            if(!file_exists($this->getRealpath())){
                $this->path = self::Get404Placeholder();
            }
        }*/

    public function getTitle($lang = null){
        return $this->getMeta($lang, 'title') ?? $this->title;
    }

    public function getDescription($lang = null){
        return $this->getMeta($lang, 'description') ?? $this->description;
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
        return null;
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


    public function getThumbnail($w, $h, $returnUrl = true)
    {
        $fn = basename($this->path);

        $p = Path::Combine(media_path(), $this->id);
        $fp = Path::Combine($p, $fn);

        $showError = false;

        if(!file_exists($p) || !file_exists($fp)){
            $fp = self::Get404PlaceholderRealPath();
            $p = dirname($fp);
            $showError = true;
            //return self::Get404Placeholder();
        }


        $newFilename = PictureHelper::GetImageName($fp, $w, $h);
        $newFilePath = Path::Combine( $p, $newFilename);
        $newFileUrl = Url::Absolute(Url::Combine( url('media'), $this->id, $newFilename));

        if($showError){
            $newFileUrl = asset('images/' . $newFilename);
        }

        if(!file_exists($newFilePath))
            PictureHelper::Crop($fp, $newFilePath, $w, $h, 100);

        return $returnUrl ? $newFileUrl : $newFilePath;
    }

    public function getType(){
        return $this->getTypeByExt();
    }

    public function getWidth()
    {
        if($this->getType() != self::T_PICTURE){
            return 0;
        }

        $path = $this->getRealpath();

        if(!file_exists($this->getRealpath())){
            $path = self::Get404PlaceholderRealPath();
        }

        list($width) = getimagesize($path);
        return $width;
    }

    public function getHeight()
    {
        if($this->getType() != self::T_PICTURE){
            return 0;
        }

        $path = $this->getRealpath();

        if(!file_exists($this->getRealpath())){
            $path = self::Get404PlaceholderRealPath();
        }

        list($width, $height) = getimagesize($path);
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

    public function getTypeByExt(){
        return self::GetMediaRepository()->GetType($this);
    }

    public function getIcon(){
        return self::GetMediaRepository()->GetIcon($this);
    }

    public function getMediaSize(){
        return self::GetMediaRepository()->GetMediaSize($this);
    }

    public static function Get404Placeholder(){
        return asset(self::IMG_404);
    }

    public static function Get404PlaceholderRealPath(){
        return public_path(self::IMG_404);
    }
}

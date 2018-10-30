<?php
namespace Omega\Repositories;

use Illuminate\Http\UploadedFile;
use Omega\Models\Media;
use Omega\Utils\Entity\VideoExternal;
use Omega\Utils\Interfaces\InterfaceMediaConstant;
use Omega\Utils\Path;
use Omega\Utils\Url;


class MediaRepository implements InterfaceMediaConstant {


    private $media;

    public function __construct(Media $media) {

        $this->media = $media;
    }

    /**
     * Get the root directory
     * @return mixed|null
     */
    public function getRoot(){
        return $this->media->where('name', 'ROOT')->first();
    }

    /**
     * Get a media by id
     * @param $id int The id of the media
     * @return Media The media
     */
    public function GetMedia($id){
        if(!isset($id) || empty($id)) return null;
        $media = $this->media->find($id);
        if(!isset($media)) return null;
        $media->readInDbMeta();
        return $media;
    }

    /**
     * Get all child medias
     * @param null|int $idParent If null, tank the root child
     * @return array<Media>
     */
    public function GetMedias($idParent = null){
        if(!isset($idParent)){
            $idParent = $this->GetRoot()->id;
        }
        return $this->media->where('fkParent', $idParent)->get();
    }

    /**
     * Get all child medias ordered
     * @param null|int $idParent If null, tank the root child
     * @return Media[]
     */
    public function GetMediasOrdered($idParent = null){
        if(!isset($idParent)){
            $idParent = $this->GetRoot()->id;
        }
        return $this->media->where('fkParent', $idParent)
            ->orderBy('type')
            ->orderBy('name')
            ->get();
    }

    /**
     * Save a media
     * @param $media Media
     * @return mixed
     */
    public function Save($media){
        $media->saveMeta();
        return $media->save();
    }

    /**
     * Delete a media
     * @param $id int The id of the media
     * @return bool|null
     */
    public function Delete($id){
        $media = $this->GetMedia($id);
        return $media->delete();
    }

    #region UTIL
    /**
     * Get the type of the media
     * @param $media Media A media
     * @return string T_PICTURE|T_VIDEO|T_MUSIC|T_DOCUMENT|T_OTHER|T_FOLDER|T_VIDEO_EXT
     */
    public function GetType($media) {
        $ext = $media->ext;
        if($media->type == self::FOLDER)
            return self::T_FOLDER;
        else if($media->type == self::EXTERNAL_VIDEO)
            return self::T_VIDEO_EXT;
        else{
            if(in_array($ext, unserialize(AUTHORIZED_PICTURE_TYPE))){
                $file_type = self::T_PICTURE;
            }
            elseif(in_array($ext, unserialize(AUTHORIZED_VIDEO_TYPE))){
                $file_type = self::T_VIDEO;
            }
            elseif(in_array($ext, unserialize(AUTHORIZED_AUDIO_TYPE))){
                $file_type = self::T_MUSIC;
            }
            elseif(in_array($ext, unserialize(AUTHORIZED_DOCUMENT_TYPE))){
                $file_type = self::T_DOCUMENT;
            }
            elseif(in_array($ext, unserialize(AUTHORIZED_OTHER_TYPE))){
                $file_type = self::T_OTHER;
            }
            else {
                $file_type = null;
            }
            return $file_type;
        }
    }

    /**
     * Get the icon correspoding to the media
     * @param $media Media A media
     * @return string A CSS class
     */
    public function GetIcon($media) {
        $type = self::GetType($media);

        $folder_icon_class = config('omega.media.icons.folder_icon_class');
        $video_icon_class = config('omega.media.icons.video_icon_class');
        $picture_icon_class = config('omega.media.icons.picture_icon_class');
        $file_icon_class = config('omega.media.icons.file_icon_class');
        $music_icon_class = config('omega.media.icons.music_icon_class');
        $videoext_icon_class = config('omega.media.icons.videoext_icon_class');

        switch($type) {
            case self::T_FOLDER:
                return $folder_icon_class;
                break;
            case self::T_PICTURE:
                return $picture_icon_class;
                break;
            case self::T_VIDEO:
                return $video_icon_class;
                break;
            case self::T_MUSIC:
                return $music_icon_class;
                break;
            case self::T_DOCUMENT:
                return $file_icon_class;
                break;
            case self::T_VIDEO_EXT:
                return $videoext_icon_class;
                break;
            default:
                return $file_icon_class;
                break;
        }
    }
    #endregion

    #region FS
    /**
     * Get the file system path to the media
     * @param $media Media A media
     * @return string The path
     */
    public function GetRealpath($media)
    {
        $fn = basename($media->path);
        $p = Path::Combine(media_path(), $media->id);
        $fp = Path::Combine($p, $fn);
        return $fp;
    }

    /**
     * Get the size of the media on the disk
     * @param $media Media A media
     * @return int|null size in bytes
     * @see File::human_filesize() To display the size in a pretty way
     */
    public function GetMediaSize($media){
        $t = self::GetType($media);
        if($t == self::T_VIDEO_EXT  )
            return null;
        return filesize(self::GetRealpath($media));
    }
    #endregion

    #region CREATE
    /**
     * @param $FILES
     * @param null|int $parent The id of the parent. If null upload to the root
     * @param $success bool True if success
     * @return null|Media
     */
    public function UploadMedia(UploadedFile &$FILE, $parent = null, &$success)
    {
        $success = true;

        $name = pathinfo($FILE->getClientOriginalName(), PATHINFO_FILENAME);
        $ext = strtolower(pathinfo($FILE->getClientOriginalName(), PATHINFO_EXTENSION));

        $media = self::CreateMedia($name, $ext, $parent);

        $path = Path::Combine(media_path(), $media->id);

        $filename = $name . '.' . $ext;

        if(!file_exists($path))
            $success = mkdir($path);

        if(!$success) {
            $this->Delete($media->id);
            return null;
        }

        $webPath = Url::Combine('media', $media->id, $filename);

        $media->path = $webPath;
        $this->Save($media);

        $FILE->move($path, $filename);

        return $media;

    }

    /**
     * Create a media of type MEDIA
     * @param $name string The name
     * @param $ext string The ext
     * @param $parent int|null The id of the parent, if null, created at the root
     * @return Media The new media
     */
    public function CreateMedia($name, $ext, $parent){

        $media = new Media();
        $media->name = $name;
        $media->ext = $ext;
        $media->type = self::MEDIA;
        $media->fkParent = $parent == null ? self::GetRoot()->id : $parent;
        $this->Save($media);
        return $media;
    }

    /**
     * Create a folder
     * @param $name string The name of the folder
     * @param $parent int|null The id of the parent, if null, created at the root
     * @return Media The new folder
     */
    public function CreateFolder($name, $parent) {
        $media = new Media();
        $media->name = $name;
        $media->type = self::FOLDER;
        $media->fkParent = $parent == null ? self::GetRoot()->id : $parent;
        $this->Save($media);
        return $media;
    }

    /**
     * Insert a external video in the database
     * @param $url string The URL to the video
     * @param $parent int|null The id of the parent, if null, created at the root
     * @return Media The new video
     */
    private function CreateVideoInDb($url, $parent){
        $media = new Media();
        $media->path = $url;
        $media->name = '';
        $media->type = self::EXTERNAL_VIDEO;
        $media->fkParent = $parent == null ? self::GetRoot()->id : $parent;
        $this->Save($media);
        return $media;
    }

    /**
     * Create a external video (youtube and vimeo)
     * @param $parent int The id of the parent
     * @param $url string The URL of the video
     * @return bool True if success
     */
    public function CreateVideo($parent, $url){
        $media = $this->CreateVideoInDb($url, $parent);
        if($media == null) return false;
        $media = new VideoExternal($media, true);
        return $media;
    }
    #endregion

    /**
     * Rename a media in the database and on the fs if needed
     * @param $mediaId int The id of the media
     * @param $newName string The new name
     * @return bool True if success
     */
    public function RenameMedia($mediaId, $newName){
        $media = $this->GetMedia($mediaId);

        $newName = strip_tags($newName);

        if($media->getType() != self::T_FOLDER){
            $newName = str_slug($newName);
        }

        $oldName = $media->name;

        $media->name = $newName;
        $media->path = Url::Combine('media', $media->id, $newName.'.'.$media->ext);

        $result = self::Save($media);
        if(!$result) return false;

        if($media->type == self::MEDIA)
        {
            $old = Path::Combine(media_path(), $media->id, $oldName .'.'. $media->ext);

            $new = Path::Combine(media_path(), $media->id, $newName .'.'. $media->ext);
            $result = rename($old, $new);
            if(!$result) return false;
        }
        return true;
    }

    public static function GetMimeType($filename) {

        $mime_types = array(

            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // video
            'mp4' => 'video/mp4',
            'mov' => 'video/quicktime',
            'ogg' => 'video/ogg',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'wav' => 'audio/wav',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'docx' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',
            'pptx' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );

        $ext = explode('.',$filename);
        $ext = array_pop($ext);
        $ext = strtolower($ext);

        if (array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        }
        elseif (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME);
            $mimetype = finfo_file($finfo, $filename);
            finfo_close($finfo);
            return $mimetype;
        }
        else {
            return 'application/octet-stream';
        }
    }

    /**
     * Get the breadcrumb scucture to the given media $id
     * @param $id int The id of the media
     * @return array of {id, name} for each breadcrumb item
     */
    public function GetBreadCrumbStructure($id){
        $bc = array();
        if($id != $this->GetRoot()->id){
            $media = $this->GetMedia($id);
            do {
                $bc[] = array(
                    'id' => $media->id,
                    'name' => $media->name
                );
                $media = $this->GetMedia($media->fkParent);
            } while ($media->id != 1);

            $bc = array_reverse($bc);
        }
        return $bc;
    }

    /**
     * Move multiple media to a new parent
     * @param $files array An array of media to move
     * @param $newParent int The id of the new parent
     * @return bool True if success
     */
    public function MoveMedias($files, $newParent) {

        foreach($files as $f) {
            $media = $this->GetMedia($f);
            $media->fkParent = $newParent;
            $this->Save($media);
        }
        return true;
    }

    /**
     * Copy multiple media to a new parent
     * @param $filesarray An array of media to copy
     * @param $newParent int The id of the new parent
     * @return bool True if success
     */
    public function CopyMedias($files, $newParent) {

        foreach($files as $f)
        {
            $media = $this->GetMedia($f);
            if($media->type == self::MEDIA)
            {
                $fileName = $media->name .'.'. $media->ext;

                // copy the media in the database
                $newMedia = $this->CreateMedia($media->name, $media->ext, $newParent);
                $newMedia->path = Url::Combine('media', $newMedia->id, $fileName);
                $this->Save($newMedia);

                $oldPath = Path::Combine(media_path(), $media->id);
                $newPath = Path::Combine(media_path(), $newMedia->id);

                if(!file_exists($newPath))
                    mkdir($newPath);

                $source = Path::Combine($oldPath, $fileName);
                $destin = Path::Combine($newPath, $fileName);

                $result = copy($source, $destin);
            }
            else if($media->type == self::EXTERNAL_VIDEO){

                $newVideo = $this->CreateVideoInDb($media->path, $newParent);
                $newVideo->name = $media->name;
                $newVideo->ext = $media->ext;
                $this->Save($newVideo);

                $fileNameSrc = $media->id . '.' . $media->ext;
                $fileNameDst = $newVideo->id . '.' . $newVideo->ext;

                $oldPath = Path::Combine(media_path(), $media->id);
                $newPath = Path::Combine(media_path(), $newVideo->id);


                if(!file_exists($newPath))
                    mkdir($newPath);


                $source = Path::Combine($oldPath, $fileNameSrc);
                $destin = Path::Combine($newPath, $fileNameDst);

                $result = copy($source, $destin);
            }
        }
        return $result;
    }
    #endregion
}
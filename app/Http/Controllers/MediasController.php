<?php

namespace Omega\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Omega\Http\Requests\Medias\CopyOrMoveRequest;
use Omega\Http\Requests\Medias\DeleteRequest;
use Omega\Http\Requests\Medias\GetDCRequest;
use Omega\Http\Requests\Medias\MakeVideoRequest;
use Omega\Http\Requests\Medias\MkdirRequest;
use Omega\Http\Requests\Medias\RenameRequest;
use Omega\Http\Requests\Medias\UpdateMediaRequest;
use Omega\Http\Requests\Medias\UpdateMediaThumbnailRequest;
use Omega\Http\Requests\Medias\UploaderRequest;
use Omega\Models\Media;
use Omega\Repositories\LangRepository;
use Omega\Repositories\MediaRepository;
use Omega\Utils\Entity\VideoExternal;
use Omega\Utils\Path;
use Omega\Utils\Url;

class MediasController extends AdminController
{
    private $mediaRepository;
    private $langRepository;

    public function __construct(MediaRepository $mediaRepository, LangRepository $langRepository) {
        parent::__construct();

        $this->mediaRepository = $mediaRepository;
        $this->langRepository = $langRepository;
    }

    public function library(){

        return view('media.library')->with([
            'isAjax' => false,
            'uid' => uniqid(),
            'rootId' => 1,
            'inception' => false,
        ]);
    }

    public function library_modal(){

        return view('media.library_ajax')->with([
            'isAjax' => true,
            'uid' => uniqid(),
            'rootId' => 1,
            'inception' => false,
        ]);
    }

    public function uploader(UploaderRequest $request){
        $parent = $request->input('parent');
        $maxUploadFileSize = humanReadableBytes(getMaximumFileUploadSize());
        return view(Request::ajax() ? 'media.uploader' : 'media.framed.uploader')->with([
            'isModal' => Request::ajax(),
            'parent' => $parent,
            'maxUploadFileSize' => $maxUploadFileSize
        ]);
    }

    public function uploadHandler(\Illuminate\Http\Request $request){

        if (!is_dir(media_path())) {
            mkdir(media_path(), 0770);
        }

        $validator = Validator::make($request->all(), [
            'file' => 'required|file',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 500);
        }

        $parent = $request->input('parent') ?? null;
        $FILE = $request->file('file');

        $success = false;
        $this->mediaRepository->UploadMedia($FILE, $parent, $success);

        return response()->json([
            'success' => $success
        ], 200);
    }

    public function getDirectoryContent(GetDCRequest $request){

        //has_right('can_access_media_library', true);

        $parent = $request->input('parent') != null ? $request->input('parent') : $this->mediaRepository->GetRoot()->id;

        $medias = $this->mediaRepository->GetMediasOrdered($parent);

        $dirContent = array();
        foreach($medias as $media)
        {
            if($media->type == Media::FOLDER) {

                $dirContent[] = array(
                    'id' => $media->id,
                    'ext' => '-',
                    'type' => 'folder',
                    'size' => '-',
                    'path' => '',
                    'parent' => $media->fkParent,
                    'mime' => '-',
                    'icon' => $this->mediaRepository->GetIcon($media),
                    'name' => $media->name,
                    'title' => $media->title,
                    'description' => $media->description,
                    'thumbnailUrl' => ''
                );
            }
            else if($media->type == Media::EXTERNAL_VIDEO)
            {
                $data = array(
                    'id' => $media->id,
                    'ext' => '-',
                    'type' 	=> 'video_ext',
                    'size' => '-',
                    'name' 	=> $media->name,
                    'path' 	=> $media->path,
                    'parent' => $media->fkParent,
                    'mime'	=> '-',
                    'icon' 	=> $this->mediaRepository->GetIcon($media),
                    'title' => $media->title,
                    'description' => $media->description,
                    'thumbnailUrl' => ''
                );
                if(isset($media->ext) && !empty($media->ext)) {
                    $data['thumbnailUrl'] = Url::CombAndAbs(url('/'), 'media', $media->id, $media->id.'.'.$media->ext);
                }
                $dirContent[] = $data;
            }
            else if($media->type == Media::MEDIA)
            {
                $type = $this->mediaRepository->GetType($media);
                $path = Path::Combine(public_path('media'), 'media', $media->id, $media->name .'.'. $media->ext);
                $dirContent[] = array(
                    'id' => $media->id,
                    'ext'  	=> $media->ext,
                    'type' 	=> $type,
                    'size' 	=> Path::getSize($path),
                    'name' 	=> $media->name,
                    'path' 	=> Url::CombAndAbs(url('/'), $media->path),
                    'parent' => $media->fkParent,
                    'mime'	=> $this->mediaRepository->GetMimeType($media->path),
                    'icon' 	=> $this->mediaRepository->GetIcon($media),
                    'title' => $media->title,
                    'description' => $media->description,
                    'thumbnailUrl' => ''
                );
            }
        }

        return response()->json([
            'content' => $dirContent,
            'breadcrumb' => $this->mediaRepository->GetBreadCrumbStructure($parent),
        ]);
    }

    public function addfolder(MkdirRequest $request) {

        //has_right('can_access_media_library', true);

        $folder = $this->mediaRepository->CreateFolder($request->input('newfolder'), $request->input('parent'));

        return response()->json([
            'success' => $folder != null
        ]);
    }

    public function delete(DeleteRequest $request) {
        //has_right('can_access_media_library', true);

        $file = $request->input('media');
        $multi = $request->input('multi');

        if($multi) {
            $files = json_decode($file, true);
            foreach ($files as $f) {
                $mediaPath = Path::Combine(media_path(), $f['id']);
                if(file_exists($mediaPath)){
                    Path::RRmdir($mediaPath);
                }
                $this->mediaRepository->Delete($f['id']);
            }
        }
        else {
            $mediaPath = Path::Combine(media_path(), $file['id']);
            if(file_exists($mediaPath)){
                Path::RRmdir($mediaPath);
            }
            $this->mediaRepository->Delete($file['id']);
        }

        return response()->json([
            'success' => true
        ]);
    }

    public function rn(RenameRequest $request) {

        $result = $this->mediaRepository->RenameMedia($request->input('id'), $request->input('newname'));

        return response()->json([
            'success' => $result
        ]);
    }

    public function mkvideo(MakeVideoRequest $request){

        $result = $this->mediaRepository->CreateVideo($request->input('parent'), $request->input('url'));

        return response()->json([
            'success' => $result
        ]);
    }

    public function copyormove(CopyOrMoveRequest $request) {

        $files = json_decode($request->input('fileList'));
        $mode = $request->input('mode');
        $newparent = $request->input('newparent');

        switch($mode){
            case 'move':
                $result = $this->mediaRepository->MoveMedias($files, $newparent);
                break;
            case 'copy':
                $result = $this->mediaRepository->CopyMedias($files, $newparent);
                break;
        }

        return response()->json([
            'success' => $result
        ]);
    }



    public function editMedia($id) {

        $media = $this->mediaRepository->GetMedia($id);
        return view('media.edit')->with([
            'media' => $media,
            'langs' => $this->langRepository->allEnabled(),
            'langEnabled' => om_config('om_enable_front_langauge')
        ]);
    }

    public function updateMedia(UpdateMediaRequest $request, $id)
    {
        $title = !empty($request->input('title')) ? $request->input('title') : null;
        $description = !empty($request->input('description')) ? $request->input('description') : null;

        if($request->has('titles')) {
            $titles = $request->input('titles');
        }
        if($request->has('descriptions')) {
            $descriptions = $request->input('descriptions');
        }

        $media = $this->mediaRepository->GetMedia($id);
        $media->title = $title;
        $media->description = $description;
        if(isset($titles)){
            foreach($titles as $lang => $title){
                $media->setTitle($title, $lang);
            }
        }
        if(isset($descriptions)){
            foreach($descriptions as $lang => $description){
                $media->setDescription($description, $lang);
            }
        }
        $media->saveMeta();
        $media->save();

        return response()->json([
            'success' => true
        ]);
    }

    public function updateMediaThumbnail(UpdateMediaThumbnailRequest $request, $id){
        $mediaId = !empty($request->input('mediaId')) ? $request->input('mediaId') : null;
        $media = $this->mediaRepository->GetMedia($id);
        $video = new VideoExternal($media);
        $res = $video->setVideoThumbnail($mediaId);

        return response()->json([
            'success' => $res
        ]);

    }

}

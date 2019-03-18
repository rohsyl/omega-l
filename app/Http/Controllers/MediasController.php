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
use Omega\Policies\OmegaGate;
use Omega\Repositories\LangRepository;
use Omega\Repositories\MediaRepository;
use Omega\Utils\Directory;
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

    /**
     * Get the media library
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function library(){
        if(OmegaGate::denies('can_access_media_library'))
            return OmegaGate::accessDeniedView();

        return view('media.library')->with([
            'isAjax' => false,
            'uid' => uniqid(),
            'rootId' => 1,
            'inception' => false,
        ]);
    }

    /**
     * Get the media library without the layout
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function library_modal(){
        if(OmegaGate::denies('can_access_media_library'))
            return OmegaGate::accessDeniedView();

        return view('media.library_ajax')->with([
            'isAjax' => true,
            'uid' => uniqid(),
            'rootId' => 1,
            'inception' => false,
        ]);
    }

    /**
     * Get the uploader form
     * @param UploaderRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function uploader(UploaderRequest $request){
        if(OmegaGate::denies('can_access_media_library'))
            return OmegaGate::accessDeniedView();

        $parent = $request->input('parent');
        $maxUploadFileSize = humanReadableBytes(getMaximumFileUploadSize());
        $isWritable = Directory::isWritable(media_path());
        return view(Request::ajax() ? 'media.uploader' : 'media.framed.uploader')->with([
            'isModal' => Request::ajax(),
            'parent' => $parent,
            'isWritable' => $isWritable,
            'maxUploadFileSize' => $maxUploadFileSize
        ]);
    }

    /**
     * Upload a file
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadHandler(\Illuminate\Http\Request $request){
        if(OmegaGate::denies('can_access_media_library'))
            return OmegaGate::jsonResponse();

        // if the media directory does not exists, then create it
        if (!is_dir(media_path())) {
            mkdir(media_path(), 0770);
        }

        // validator for the uploaded file
        $validator = Validator::make($request->all(), [
            'file' => 'required|file',
        ]);

        // stop upload of the file fails the validation
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 500);
        }

        $parent = $request->input('parent') ?? null;
        $FILE = $request->file('file');

        $success = false;
        // upload the media
        $this->mediaRepository->UploadMedia($FILE, $parent, $success);

        return response()->json([
            'success' => $success
        ], 200);
    }

    /**
     * Get the content of a directory
     * @param GetDCRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDirectoryContent(GetDCRequest $request){

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

    /**
     * Add a new direcotry
     * @param MkdirRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addfolder(MkdirRequest $request) {

        $folder = $this->mediaRepository->CreateFolder($request->input('newfolder'), $request->input('parent'));

        return response()->json([
            'success' => $folder != null
        ]);
    }

    /**
     * Delete a file or a directory
     * @param DeleteRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(DeleteRequest $request) {

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

    /**
     * Rename a file or a directory
     * @param RenameRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function rn(RenameRequest $request) {

        $result = $this->mediaRepository->RenameMedia($request->input('id'), $request->input('newname'));

        return response()->json([
            'success' => $result
        ]);
    }

    /**
     * Create a new external video instance
     * @param MakeVideoRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function mkvideo(MakeVideoRequest $request){

        $result = $this->mediaRepository->CreateVideo($request->input('parent'), $request->input('url'));

        return response()->json([
            'success' => $result
        ]);
    }

    /**
     * Copy of Move a file / directory
     * @param CopyOrMoveRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Get the form to edit a media
     * @param $id int
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editMedia($id) {
        if(OmegaGate::denies('can_access_media_library'))
            return OmegaGate::accessDeniedView();

        $media = $this->mediaRepository->GetMedia($id);
        return view('media.edit')->with([
            'media' => $media,
            'langs' => $this->langRepository->allEnabled(),
            'langEnabled' => om_config('om_enable_front_langauge')
        ]);
    }

    /**
     * Update the media
     * @param UpdateMediaRequest $request
     * @param $id int
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Update the thumbnail of a media
     * @param UpdateMediaThumbnailRequest $request
     * @param $id int
     * @return \Illuminate\Http\JsonResponse
     */
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

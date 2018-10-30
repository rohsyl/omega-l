<?php

namespace Omega\Http\Controllers;

use Illuminate\Http\Request;
use Omega\Repositories\MediaRepository;
use Omega\Repositories\ModuleRepository;
use Omega\Repositories\PageRepository;

class LinkChooserController extends AdminController
{
    private $pageRepository;
    private $mediaRepository;
    private $moduleRepository;

    public function __construct(PageRepository $pageRepository, MediaRepository $mediaRepository, ModuleRepository $moduleRepository) {
        parent::__construct();

        $this->pageRepository = $pageRepository;
        $this->mediaRepository = $mediaRepository;
        $this->moduleRepository = $moduleRepository;
    }

    public function getForm(){
        return view('linkchooser.form')->with([
            'mediaIdParent' => $this->mediaRepository->getRoot()->id,
            'pages' => $this->pageRepository->all()
        ]);
    }

    public function getBreadcrumb($id){
        return response()->json([
            'bc' => $this->mediaRepository->GetBreadCrumbStructure($id),
        ]);
    }

    public function getDirectoryContent($id){
        return view('linkchooser.dc')->with([
            'm' => $this->mediaRepository->GetMedia($id),
            'medias' => $this->mediaRepository->GetMedias($id)
        ]);
    }
}

<?php

namespace Omega\Http\Controllers;

use Illuminate\Http\Request;
use Omega\Http\Requests\Modulearea\AddPositionRequest;
use Omega\Http\Requests\Modulearea\SaveLangRequest;
use Omega\Http\Requests\Modulearea\SetOrderRequest;
use Omega\Repositories\LangRepository;
use Omega\Repositories\ModuleAreaRepository;
use Omega\Repositories\PositionRepository;
use Omega\Repositories\ThemeRepository;

class ModuleareaController extends AdminController
{
    private $moduleAreaRepository;
    private $themeRepository;
    private $positionRepository;
    private $langRepository;

    public function __construct(ModuleAreaRepository $moduleAreaRepository,
                                ThemeRepository $themeRepository,
                                PositionRepository $positionRepository,
                                LangRepository $langRepository) {
        parent::__construct();
        $this->moduleAreaRepository = $moduleAreaRepository;
        $this->themeRepository = $themeRepository;
        $this->positionRepository = $positionRepository;
        $this->langRepository = $langRepository;
    }


    public function listplugin($pageId = null)
    {
        return response()->json([
            'result'  => true,
            'plugins' => $this->moduleAreaRepository->getInsertablePlugins($pageId)
        ]);
    }

    public function listmodulebyplugin($pluginId, $pageId = null)
    {
        return response()->json([
            'result'  => true,
            'modules' => $this->moduleAreaRepository->getAllModuleByPluginAndPage($pluginId, $pageId)
        ]);
    }

    public function addPosition(AddPositionRequest $request, $pageId = null)
    {
        $areaName = $request->input('areaName');
        $moduleId = $request->input('moduleId');

        $currentTheme = $this->themeRepository->getCurrentThemeName();
        $ma = $this->moduleAreaRepository->getByNameAndThemeName($areaName, $currentTheme);

        $this->positionRepository->create($ma, $moduleId, $pageId);

        return response()->json([
            'result'  => true
        ]);
    }

    public function deletePosition($id){
        $this->positionRepository->delete($id);
        return response()->json([
            'result'  => true
        ]);
    }

    public function setOnAllPages($id, $set, $pageId = null)
    {
        $this->positionRepository->setOnAllPages($id, $set, $pageId);
        return response()->json([
            'result'  => true
        ]);
    }

    public function setOrder(SetOrderRequest $request)
    {
        $data = json_decode($request->input('order'), true);
        foreach($data as $d) {
            $currentTheme = $this->themeRepository->getCurrentThemeName();
            $ma = $this->moduleAreaRepository->getByNameAndThemeName($d['modulearea'], $currentTheme);
            $this->positionRepository->updateOrder($d['positionid'], $d['order'], $ma->id);
        }
        return response()->json([
            'result'  => true
        ]);
    }

    public function getLangForm($positionid){

        $position = $this->positionRepository->get($positionid);

        return view('pages.module.langsettings')->with([
            'position' => $position,
            'langs' => to_select($this->langRepository->allEnabled(), 'name', 'slug', [null => __('Any')])
        ]);
    }

    public function saveLang(SaveLangRequest $request){

        $this->positionRepository->setlang($request->input('posId'), $request->input('posLang'));

        return response()->json([
            'success' => true
        ]);
    }
}

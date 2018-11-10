<?php
namespace OmegaPlugin\GoogleAnalytics;


use Illuminate\Support\Facades\Validator;
use Omega\Models\Module;
use Omega\Repositories\ModuleRepository;
use Omega\Utils\Plugin\BController;

class BControllerGoogleAnalytics extends  BController {

    private $rules = [
        'id' => 'nullable|regex:/^ua-\d{4,9}-\d{1,4}$/i',
        'enable' => 'required|boolean'
    ];

    private $moduleName;

    private $moduleRepository;

    public function __construct() {
        parent::__construct('google_analytics');
        $this->moduleName = "Google Analytics";
        $this->moduleRepository = new ModuleRepository(new Module());
    }

    public function install() {
        $this->moduleRepository->create($this->id, $this->moduleName);
        return true;
    }

    public  function uninstall() {
        $this->moduleRepository->destroyByName($this->moduleName);
        return true;
    }

    public function index() {

        $module = $this->moduleRepository->getByName($this->moduleName);
        $param = isset($module) ? json_decode($module->param, true) : array();

        $m['id'] = isset($param['id']) ? $param['id'] : null;
        $m['enable'] = isset($param['enable']) ? $param['enable'] : true;
        return $this->view('index')->with($m);
    }

    public function save(){

        $request = request();
        $validator = Validator::make($request->all(), $this->rules);

        if ($validator->fails()) {
            return $this->redirect('index')
                ->withErrors($validator)
                ->withInput();
        }

        $module = $this->moduleRepository->getByName($this->moduleName);
        $this->moduleRepository->saveParam($module, [
            'id' => $request->input('id'),
            'enable' => $request->input('enable')
        ]);

        toast()->success(__('Saved'));
        return $this->redirect('index');
    }

    public function help(){
        return $this->view('help');
    }
}
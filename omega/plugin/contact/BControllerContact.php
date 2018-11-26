<?php
namespace OmegaPlugin\Contact;

use Illuminate\Support\Facades\Validator;
use Omega\Utils\Plugin\BController;

class BControllerContact extends  BController {


    private $rules = [
        'logo' => 'nullable|integer',
        'displayLogo' => 'required|boolean',
        'phone' => 'nullable|string',
        'mobile' => 'nullable|string',
        'fax' => 'nullable|string',
        'mail_info' => 'nullable|email',
        'mail' => 'nullable|email',
        'name' => 'nullable|string',
        'street' => 'nullable|string',
        'npa' => 'nullable|string',
        'locality' => 'nullable|string',
        'conf_message' => 'nullable|string',
        'is_antispam' => 'required|boolean',
        'key_site' => 'nullable|string',
        'key_secret' => 'nullable|string',
    ];

    public function __construct(){
        parent::__construct('contact');
    }

    public function install() {
        parent::runSql($this->root . DS . 'sql/install.sql');
        return true;
    }


    public function index() {

        $param = json_decode(om_config('contact_param'), true);
        $param = isset($param) ? $param : array();

        return $this->view('index')->with([
            'paramData' => $param
        ]);
    }


    public function save(){

        $request = request();

        $validator = Validator::make($request->all(), $this->rules);

        if ($validator->fails()) {
            return $this->redirect('index')
                ->withErrors($validator)
                ->withInput();
        }

        $param = array(
            'contactLogo' => $request->input('logo'),
            'displayLogo' => $request->input('displayLogo'),
            'phone' => $request->input('phone'),
            'mobile' => $request->input('mobile'),
            'fax' => $request->input('fax'),
            'mail_info' => $request->input('mail_info'),
            'mail' => $request->input('mail'),
            'name' => $request->input('name'),
            'street' => $request->input('street'),
            'npa' => $request->input('npa'),
            'locality' => $request->input('locality'),
            'conf_message' => $request->input('conf_message'),
            'is_antispam' => $request->input('is_antispam'),
            'key_site' => $request->input('key_site'),
            'key_secret' => $request->input('key_secret'),
        );

        om_config(['contact_param' => json_encode($param)]);

        toast()->success(__('Settings saved !'));
        return $this->redirect('index');

    }
}
<?php
namespace OmegaPlugin\Contact;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Omega\Utils\Entity\Media;
use Omega\Utils\Plugin\FController;
use Omega\Utils\Url;
use OmegaPlugin\Contact\Mail\ContactMail;


class FControllerContact extends FController {

    const VIEW_FORM = 1;
    const VIEW_INFO = 2;

    private $rules = [
        'name' => 'required|string',
        'mail' => 'required|email',
        'phone' => 'nullable|string',
        'message' => 'required|string',
    ];

    public function __construct(){
        parent::__construct('contact');
        $this->includeFile('captcha/simple-php-captcha.php');
    }

    public function registerDependencies()
    {
        return array(
            'css' => array(
                $this->asset('css/styles.css')
            ),
            'js' => array(
            )
        );
    }

    public function display( $userParam, $data )
    {

        $param = json_decode(om_config('contact_param'), true);
        $param = isset($param) ? $param : array();

        switch($data['view']['value'])
        {
            case self::VIEW_INFO:

                $image = function() use ($param){
                    if(isset($param['contactLogo']))
                    {
                        return Media::Get($param['contactLogo']);
                    }
                    return null;
                };

                return $this->view('display_info')->with([
                    'param' => $param,
                    'image' => $image,
                ]);
                break;

            case self::VIEW_FORM:
                $m = array(
                    'messageType' => null,
                    'message' => null
                );

                $request = request();

                $isAntispam = $param['is_antispam'];
                if($request->isMethod('post')){

                    $validator = Validator::make($request->all(), $this->rules);

                    $validator->after(function ($validator) use ($isAntispam, $request) {
                        if ($isAntispam && !$request->has('result')) {
                            $validator->errors()->add('result', __('The captcha must be resolved!'));
                        }
                        else if(session('captcha')['code'] != $request->input('result')){
                            $validator->errors()->add('result', __('Invalid captcha!'));

                        }
                    });

                    if($validator->fails()){
                        return redirect()
                            ->back()
                            ->withErrors($validator)
                            ->withInput();
                    }

                    $mail = $param['mail'];

                    Mail::to($mail)
                        ->send(new ContactMail($this, $request->all()));

                    return redirect()->back()->with('success', $param['conf_message']);
                }


                if ($isAntispam) {
                    session(['captcha' => simple_php_captcha()]);
                }

                $m['isAntispam'] = $isAntispam;
                return $this->view('display')->with($m);
                break;
        }
    }
}
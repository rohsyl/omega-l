<?php
namespace OmegaPlugin\Contact;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Omega\Facades\OmegaUtils;
use Omega\Utils\Entity\Media;
use Omega\Utils\Plugin\FController;
use Omega\Utils\Url;
use OmegaPlugin\Contact\Mail\ContactMail;


class FControllerContact extends FController {

    const VIEW_FORM = 1;
    const VIEW_INFO = 2;

    const RE_CAPCHAT_URL = 'https://www.google.com/recaptcha/api/siteverify';
    const RE_CAPCHAT_JS = 'https://www.google.com/recaptcha/api.js?render=';
    const RE_CAPCHAT_THRESHOLD = 0.5;

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


                $isAntispam = isset($param['is_antispam'])
                            && isset($param['key_site'])
                            && isset($param['key_secret']) ? $param['is_antispam'] : false;

                if($request->isMethod('post')){



                    $validator = Validator::make($request->all(), $this->rules);





                    $validator->after(function ($validator) use ($isAntispam, $request, $param) {
                        if($isAntispam){
                            if($request->has('g-recaptcha-response')){
                                $client = new Client();
                                $response = $client->request('POST', self::RE_CAPCHAT_URL, [
                                    'form_params' => [
                                        'secret' => $param['key_secret'],
                                        'response' => $request->input('g-recaptcha-response'),
                                    ],
                                ]);

                                if($response->getStatusCode() == 200){
                                    $content = $response->getBody()->getContents();

                                    $data = json_decode($content);

                                    if($data->success) {
                                        if($data->score > self::RE_CAPCHAT_THRESHOLD){
                                            // all good, it's not a bot !
                                            return;
                                        }
                                    }
                                }
                            }
                            $validator->errors()->add('recaptcha', __('Error while validating captcha'));
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
                    OmegaUtils::addDependencies([
                        'js' => [self::RE_CAPCHAT_JS . $param['key_site']]
                    ]);
                }

                $m['isAntispam'] = $isAntispam;
                $m['key_site'] = isset($param['key_site']) ? $param['key_site'] : '';
                return $this->view('display')->with($m);
                break;
        }
    }
}
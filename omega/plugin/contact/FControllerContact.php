<?php
namespace OmegaPlugin\Contact;

use Illuminate\Support\Facades\Validator;
use Omega\Utils\Plugin\FController;
use Omega\Utils\Url;


class FControllerContact extends FController {

    const VIEW_FORM = 1;
    const VIEW_INFO = 2;

    private $rules = [
        'name' => 'required|string',
        'mail' => 'required|email',
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
                return $this->view('display_info')->with([
                    'param' => $param
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


                    // Send mail
                    /*
                    $paramData = $param;


                    $from = array();
                    $from[] = MailHelper::GetFromAddress();
                    $from[] =  $from[0];

                    $replyTo = array();
                    $replyTo[] = $form->getValue('mail');
                    $replyTo[] = $form->getValue('name');

                    $to = array();
                    $to[] = $paramData['mail'];

                    $subject = $this->buildSubject($form);
                    $body = $this->buildBody($form, $paramData);

                    $result = MailHelper::SendMail(
                        $from,
                        $replyTo,
                        $to,
                        $subject,
                        $body,
                        strip_tags($body),
                        true
                    );

                    if ($result === true) {
                        $m['message'] = $paramData['conf_message'];
                        $m['messageType'] = 'success';
                        $_POST = null;
                    } else {
                        $m['message'] = $result;
                        $m['messageType'] = 'danger';
                    }
                    */

                }


                if ($isAntispam) {
                    session(['captcha' => simple_php_captcha()]);
                }

                $m['isAntispam'] = $isAntispam;
                return $this->view('display')->with($m);
                break;
        }
    }

    private function buildBody($form, $paramData)
    {
        $message = $form->getValue('message');
        $name = $form->getValue('name');
        $phone = $form->getValue('phone');
        $mail = $form->getValue('mail');

        $body = '';
        $body .= '<p>Nom : ' . $name . '</p>';
        $body .= '<p>Mail : ' . $mail . '</p>';
        $body .= '<p>Téléphone : ' . $phone . '</p>';
        $body .= '<p>Message : <br /> "' . $message . '"</p>';
        //$body .= '<p>' . $paramData['mail_sign'] . '</p>';

        return $body;
    }

    private function buildSubject($form)
    {
        $name = $form->getValue('name');
        $domaine = Url::ParseDomaine(ABSPATH);

        $subject = 'Message de "';
        $subject .= $name . '"';
        $subject .= 'depuis ' . $domaine;

        return $subject;
    }
}
<?php
namespace Omega\Plugin\Contact;

use Omega\Library\Plugin\FController;
use Omega\Library\Util\Form;
use Omega\Library\Util\MailHelper;
use Omega\Library\Util\Url;
use Omega\Library\Util\Config as ConfigHelper;


class FControllerContact extends FController {

    const VIEW_FORM = 1;
    const VIEW_INFO = 2;

    public function __construct(){
        parent::__construct('contact');
        $this->includeFile('captcha/simple-php-captcha.php');
    }

    public function registerDependencies()
    {
        return array(
            'css' => array(
                'plugin/contact/css/style.css'
            ),
            'js' => array(
            )
        );
    }

    public function display( $userParam, $data )
    {

        $param = json_decode(ConfigHelper::get('contact_param'), true);
        $param = isset($param) ? $param : array();

        switch($data['view']['value'])
        {
            case self::VIEW_INFO:
                $m['param'] = $param;
                return $this->partialView('display-info', $m);
                break;

            case self::VIEW_FORM:
                $m = array(
                    'messageType' => null,
                    'message' => null
                );

                $form = new Form('contactForm');
                $isAntispam = $param['is_antispam'];
                if($form->isPosted()) {
                    $isInvalid = false;
                    $errorMessage = '';
                    if( !$form->checkValue('name') )
                    {
                        $errorMessage .= 'Le champs "Nom" est vide !<br />';
                        $isInvalid = true;
                    }
                    if( !$form->checkValue('mail')  || !filter_var($form->getValue('mail'), FILTER_VALIDATE_EMAIL))
                    {
                        $errorMessage .= 'Le champs "Mail" est vide ou le mail est invalide !<br />';
                        $isInvalid = true;
                    }
                    if( !$form->checkValue('message') )
                    {
                        $errorMessage .= 'Le champs "Message" est vide !<br />';
                        $isInvalid = true;
                    }
                    if($isAntispam && !$form->checkValue('result'))
                    {
                        $errorMessage .= 'Veuillez remplir le Captcha !<br />';
                        $isInvalid = true;
                    }
                    else
                    {
                        if ($_SESSION['captcha']['code'] != $form->getValue('result')) {
                            $errorMessage .= 'Captcha incorrect !<br />';
                            $isInvalid = true;
                        }
                    }

                    if(!$isInvalid) {

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

                        // TODO : Send confirmation message
                    }
                    else
                    {
                        $m['message'] = $errorMessage;
                        $m['messageType'] = 'danger';
                    }
                }
                if ($isAntispam) {
                    $_SESSION['captcha'] = simple_php_captcha();
                }

                $m['isAntispam'] = $isAntispam;
                return $this->view($m);
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
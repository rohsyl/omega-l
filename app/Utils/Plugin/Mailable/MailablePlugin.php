<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 12.11.18
 * Time: 13:13
 */

namespace Omega\Utils\Plugin\Mailable;


use Illuminate\Mail\Mailable;
use Omega\Utils\Plugin\AbstractController;

class MailablePlugin extends Mailable
{
    private $controller;

    public function __construct(AbstractController $controller) {
        $this->controller = $controller;
    }

    public function view($view, array $data = [])
    {
        return $this->controller->view($view)->with($data);
    }
}
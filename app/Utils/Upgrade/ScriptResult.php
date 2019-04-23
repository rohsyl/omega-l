<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 18.04.19
 * Time: 18:24
 */

namespace Omega\Utils\Upgrade;


class ScriptResult {

    private $exception;
    private $success = true;

    private $messages = [];

    public function message($message) {
        $this->messages[] = $message;
    }

    public function exception($e) {
        $this->exception = $e;
    }

    public function failed() {
        $this->success = false;
        $this->message('The execution of this script failed.');
    }

    public function hasFailed() {
        return !$this->success;
    }

    public function getMessages() {
        return $this->messages;
    }

    public function getException() {
        return $this->exception;
    }
}
<?php

namespace OmegaPlugin\Contact\Mail;

use http\Env\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Omega\Utils\Plugin\Mailable\MailablePlugin;

class ContactMail extends MailablePlugin
{
    use Queueable, SerializesModels;

    private $inputs;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($controller, $inputs)
    {
        parent::__construct($controller);
        $this->inputs = $inputs;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject(__('Message of ' . $this->inputs['name']));
        $this->from('noreply@' . request()->getHost(), 'Omega contact');
        $this->replyTo($this->inputs['mail']);
        return $this->plugin_view('mail', $this->inputs);

    }
}

<?php

namespace OmegaPlugin\Contact\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Omega\Utils\Plugin\Mailable\MailablePlugin;

class ContactMail extends MailablePlugin
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($controller)
    {
        parent::__construct($controller);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('view.name');
    }
}

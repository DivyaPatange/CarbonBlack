<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Subscribe; 

class SubscribeMail extends Mailable
{
    use Queueable, SerializesModels;
    public $subscribe;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subscribe)
    {
        $this->subscribe = $subscribe;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('email.mail')->with('user', $this->user);
        return $this->from('carbonblack.education@gmail.com')->subject('Successfully Register')->view('email.subscribe')->with('subscribe', $this->subscribe);
    }
}

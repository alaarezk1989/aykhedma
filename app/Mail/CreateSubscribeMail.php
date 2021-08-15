<?php

namespace App\Mail;

use App\Models\Subscribe;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateSubscribeMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    /**
     * @var Subscribe
     */
    public $subscribe;
    public $user;

    /**
     * Create a new message instance.
     *
     * @param Subscribe $subscribe
     */
    public function __construct(Subscribe $subscribe, User $user)
    {
        $this->subscribe = $subscribe;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subscribe->title)->view('mails.create_new_subscribe');
    }
}

<?php

namespace App\Mail;

use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TicketReplayMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $ticketReply;
    public $user;

    public function __construct(TicketReply $ticketReply, User $user)
    {
        $this->ticketReply = $ticketReply;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(trans('ticket_replay')." # ".$this->ticketReply->ticket_id)->view('mails.ticket_replay_'.\App::getLocale());
    }
}

<?php

namespace App\Events;

use App\Models\TicketReply;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class TicketReplyCreatedEvent
{
    use Dispatchable , SerializesModels;
    public $ticketReply;
    public $message;
    public $objectType;
    public $objectId;

    /**
     * TicketEditedEvent constructor.
     * @param Ticket $Ticket
     */
    public function __construct(TicketReply $ticketReply)
    {
        $this->ticketReply = $ticketReply;
        $this->message = 'created'; 
        $this->objectType = get_class($ticketReply);
        $this->objectId = $ticketReply->id;
    }
}

<?php

namespace App\Events;


use App\Models\Ticket;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class TicketCreatedEvent
{
    use Dispatchable , SerializesModels;
    public $Ticket;
    public $message;
    public $objectType;
    public $objectId;

    /**
     * TicketEditedEvent constructor.
     * @param Ticket $Ticket
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
        $this->message = 'created';
        $this->objectType = get_class($ticket);
        $this->objectId = $ticket->id;
    }
}

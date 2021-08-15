<?php


namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use App\Models\Ticket;

class TicketDeletedEvent
{
    use Dispatchable, SerializesModels;

    public $product;
    public $message;
    public $objectType;
    public $objectId;

    /**
     * ProductEvent constructor.
     * @param Ticket $Ticket
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
        $this->message = 'deleted';
        $this->objectType = get_class($ticket);
        $this->objectId = $ticket->id;
    }
}

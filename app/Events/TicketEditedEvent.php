<?php

namespace App\Events;

use App\Models\Ticket;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class TicketEditedEvent
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
        $this->message = 'updated';

        if ($ticket->wasChanged('status')){
            $status = $ticket->status == 2 ? 'resolved' : 'pending';
            $this->message = 'changed_status_to_' .$status;
        }

        if($ticket->wasChanged('assignee_id')){
            $this->message ='changed_assigned_user_of';
        }
        
        $this->objectType = get_class($ticket);
        $this->objectId = $ticket->id;
    }
}

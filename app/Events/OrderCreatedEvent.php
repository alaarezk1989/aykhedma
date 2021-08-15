<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class OrderCreatedEvent
{
    use Dispatchable, SerializesModels;

    public $order;
    public $message;
    public $objectType;
    public $objectId;

    /**
     * OrderEditedEvent constructor.
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->message = 'created';
        $this->objectType = get_class($order);
        $this->objectId = $order->id;
    }
}

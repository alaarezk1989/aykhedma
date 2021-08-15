<?php

namespace App\Events;

use App\Constants\OrderStatus;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class OrderEditedEvent
{
    use Dispatchable, SerializesModels;

    public $order;
    public $message;
    public $objectType;
    public $objectId;
    public $dataPoints;

    /**
     * OrderEditedEvent constructor.
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;

        $this->message = 'updated';
        if ($order->wasChanged('status')) {
            $status = OrderStatus::getValue($order->status);
            $this->message = 'changed_status_to_' . $status;
        }

        $this->objectType = get_class($order);
        $this->objectId = $order->id;
    }
}

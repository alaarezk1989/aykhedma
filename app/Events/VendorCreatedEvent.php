<?php

namespace App\Events;


use App\Models\Vendor;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class VendorCreatedEvent
{
    use Dispatchable, SerializesModels;

    public $vendor;
    public $message;
    public $objectType;
    public $objectId;

    /**
     * VendorCreatedEvent constructor.
     * @param Vendor $vendor
     */
    public function __construct(Vendor $vendor)
    {
        $this->vendor = $vendor;
        $this->message = 'created';
        $this->objectType = get_class($vendor);
        $this->objectId = $vendor->id;
    }
}

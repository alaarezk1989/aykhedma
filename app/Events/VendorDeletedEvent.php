<?php

namespace App\Events;


use App\Models\Vendor;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class VendorDeletedEvent
{
    use Dispatchable, SerializesModels;

    public $vendor;
    public $message;
    public $objectType;
    public $objectId;

    /**
     * VendorDeletedEvent constructor.
     * @param Vendor $vendor
     */
    public function __construct(Vendor $vendor)
    {
        $this->vendor = $vendor;
        $this->message = 'deleted';
        $this->objectType = get_class($vendor);
        $this->objectId = $vendor->id;
    }
}

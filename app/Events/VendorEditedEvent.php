<?php

namespace App\Events;


use App\Models\Vendor;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class VendorEditedEvent
{
    use Dispatchable , SerializesModels;
    public $vendor;
    public $message;
    public $objectType;
    public $objectId;

    /**
     * VendorEditedEvent constructor.
     * @param Vendor $vendor
     */
    public function __construct(Vendor $vendor)
    {
        $this->vendor = $vendor;
        $this->message = 'updated';
        if ($vendor->wasChanged('active')) {
            $status = $vendor->active ? 'active' : 'disabled';
            $this->message = 'changed_status_to_' . $status;
        }

        $this->objectType = get_class($vendor);
        $this->objectId = $vendor->id;
    }
}

<?php


namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use App\Models\ShippingCompany;

class ShippingCompanyEditedEvent
{
    use Dispatchable, SerializesModels;

    public $shippingCompany;
    public $message;
    public $objectType;
    public $objectId;

    /**
     * ProductEvent constructor.
     * @param ShippingCompany $ShippingCompany
     */
    public function __construct(ShippingCompany $shippingCompany)
    {
        $this->shippingCompany = $shippingCompany;
        $this->message = 'updated';
        if ($shippingCompany->wasChanged('active')) {
            $status = $shippingCompany->active ? 'active' : 'disabled';
            $this->message = 'changed_status_to_' . $status;
        }

        $this->objectType = get_class($shippingCompany);
        $this->objectId = $shippingCompany->id;
    }


}

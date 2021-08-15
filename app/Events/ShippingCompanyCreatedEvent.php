<?php


namespace App\Events;

use App\Models\ShippingCompany;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class ShippingCompanyCreatedEvent
{
    use Dispatchable , SerializesModels;
    public $shippingCompany;
    public $message;
    public $objectType;
    public $objectId;

    /**
     * ShippingCompanyCreatedEvent constructor.
     * @param ShippingCompany $ShippingCompany
     */
    public function __construct(ShippingCompany $shippingCompany)
    {
        $this->shippingCompany = $shippingCompany;
        $this->message = 'created'; 
        $this->objectType = get_class($shippingCompany);
        $this->objectId = $shippingCompany->id;
    }
}

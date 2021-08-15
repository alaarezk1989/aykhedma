<?php


namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use App\Models\ShippingCompany;

class ShippingCompanyDeletedEvent
{
    use Dispatchable, SerializesModels;

    public $shippingCompany;
    public $message;
    public $objectType;
    public $objectId;

    /**
     * ShippingCompanyEvent constructor.
     * @param ShippingCompany $ShippingCompany
     */
    public function __construct(ShippingCompany $shippingCompany)
    {
        $this->shippingCompany = $shippingCompany;
        $this->message = 'deleted';
        $this->objectType = get_class($shippingCompany);
        $this->objectId = $shippingCompany->id;
    }
}

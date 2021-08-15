<?php


namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use App\Models\BranchProduct;

class BranchProductCreatedEvent
{
    use Dispatchable, SerializesModels;

    public $branchProduct;
    public $message;
    public $objectType;
    public $objectId;

    /**
     * BranchProductCreatedEvent constructor.
     * @param BranchProduct $branchProduct
     */
    public function __construct(BranchProduct $branchProduct)
    {
        $this->branchProduct = $branchProduct;
        $this->message = 'created';
        $this->objectType = get_class($branchProduct);
        $this->objectId = $branchProduct->id;
    }


}

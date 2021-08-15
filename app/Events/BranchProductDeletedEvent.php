<?php


namespace App\Events;

use App\Models\BranchProduct;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class BranchProductDeletedEvent
{
    use Dispatchable, SerializesModels;

    public $branchProduct;
    public $message;
    public $objectType;
    public $objectId;

    /**
     * BranchProductDeletedEvent constructor.
     * @param BranchProduct $branchProduct
     */
    public function __construct(BranchProduct $branchProduct)
    {
        $this->branchProduct = $branchProduct;
        $this->message = 'deleted';
        $this->objectType = get_class($branchProduct);
        $this->objectId = $branchProduct->id;
    }
}

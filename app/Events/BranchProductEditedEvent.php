<?php


namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use App\Models\BranchProduct;

class BranchProductEditedEvent
{
    use Dispatchable, SerializesModels;

    public $branchProduct;
    public $message;
    public $objectType;
    public $objectId;

    /**
     * BranchProductEditedEvent constructor.
     * @param BranchProduct $branchProduct
     */
    public function __construct(BranchProduct $branchProduct)
    {
        $this->branchProduct = $branchProduct;
        $this->message = 'updated';
        if ($branchProduct->wasChanged('active')) {
            $status = $branchProduct->active ? 'active' : 'disabled';
            $this->message = 'changed_status_to_' . $status;
        }

        $this->objectType = get_class($branchProduct);
        $this->objectId = $branchProduct->id;
    }


}

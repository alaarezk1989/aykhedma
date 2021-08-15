<?php

namespace App\Events;


use App\Models\Branch;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class BranchEditedEvent
{
    use Dispatchable , SerializesModels;
    public $branch;
    public $message;
    public $objectType;
    public $objectId;

    /**
     * BranchEditedEvent constructor.
     * @param Branch $branch
     */
    public function __construct(Branch $branch)
    {
        $this->branch = $branch;
        $this->message = 'updated';
        if ($branch->wasChanged('active')) {
            $status = $branch->active ? 'active' : 'disabled';
            $this->message = 'changed_status_to_' . $status;
        }

        $this->objectType = get_class($branch);
        $this->objectId = $branch->id;
    }
}

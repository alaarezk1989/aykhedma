<?php

namespace App\Events;

use App\Models\Branch;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class BranchDeletedEvent
{
    use Dispatchable, SerializesModels;

    public $branch;
    public $message;
    public $objectType;
    public $objectId;

    /**
     * BranchDeletedEvent constructor.
     * @param Branch $branch
     */
    public function __construct(Branch $branch)
    {
        $this->branch = $branch;
        $this->message = 'deleted';
        $this->objectType = get_class($branch);
        $this->objectId = $branch->id;
    }
}

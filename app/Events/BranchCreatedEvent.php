<?php

namespace App\Events;

use App\Models\Branch;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class BranchCreatedEvent
{
    use Dispatchable, SerializesModels;

    public $branch;
    public $message;
    public $objectType;
    public $objectId;

    /**
     * BranchCreatedEvent constructor.
     * @param Branch $branch
     */
    public function __construct(Branch $branch)
    {
        $this->branch = $branch;
        $this->message = 'created';
        $this->objectType = get_class($branch);
        $this->objectId = $branch->id;
    }
}

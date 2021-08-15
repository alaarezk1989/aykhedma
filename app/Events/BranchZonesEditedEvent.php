<?php

namespace App\Events;

use App\Models\BranchZone;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class BranchZonesEditedEvent
{
    use Dispatchable , SerializesModels;
    public $branchZone;
    public $message;
    public $objectType;
    public $objectId;

    /**
     * BranchZonesEditedEvent constructor.
     * @param BranchZone $branchZone
     */
    public function __construct(BranchZone $branchZone)
    {
        $this->branchZone = $branchZone;
        $this->message = 'updated';
        $this->objectType = get_class($branchZone);
        $this->objectId = $branchZone->id;
    }
}

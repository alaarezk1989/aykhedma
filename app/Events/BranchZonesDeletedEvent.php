<?php


namespace App\Events;

use App\Models\BranchZone;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class BranchZonesDeletedEvent
{
    use Dispatchable, SerializesModels;

    public $branchZone;
    public $message;
    public $objectType;
    public $objectId;

    /**
     * BranchZoneDeletedEvent constructor.
     * @param BranchZone $branchZone
     */
    public function __construct(BranchZone $branchZone)
    {
        $this->branchZone = $branchZone;
        $this->message = 'deleted';
        $this->objectType = get_class($branchZone);
        $this->objectId = $branchZone->id;
    }
}

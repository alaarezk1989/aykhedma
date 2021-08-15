<?php


namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use App\Models\BranchZone;

class BranchZonesCreatedEvent
{
    use Dispatchable, SerializesModels;

    public $branchZone;
    public $message;
    public $objectType;
    public $objectId;

    /**
     * BranchZoneCreatedEvent constructor.
     * @param BranchZone $branchZone
     */
    public function __construct(BranchZone $branchZone)
    {
        $this->branchZone = $branchZone;
        $this->message = 'created';
        $this->objectType = get_class($branchZone);
        $this->objectId = $branchZone->id;
    }


}

<?php

namespace App\Events;


use App\Models\Unit;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class UnitEditedEvent
{
    use Dispatchable , SerializesModels;
    public $unit;
    public $message;
    public $objectType;
    public $objectId;

    /**
     * UnitEditedEvent constructor.
     * @param Unit $unit
     */
    public function __construct(Unit $unit)
    {
        $this->unit = $unit;
        $this->message = 'updated';
        if ($unit->wasChanged('active')) {
            $status = $unit->active ? 'active' : 'disabled';
            $this->message = 'changed_status_to_' . $status;
        }

        $this->objectType = get_class($unit);
        $this->objectId = $unit->id;
    }
}

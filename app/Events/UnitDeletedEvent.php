<?php

namespace App\Events;


use App\Models\Unit;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class UnitDeletedEvent
{
    use Dispatchable, SerializesModels;

    public $unit;
    public $message;
    public $objectType;
    public $objectId;

    /**
     * UnitDeletedEvent constructor.
     * @param Unit $unit
     */
    public function __construct(Unit $unit)
    {
        $this->unit = $unit;
        $this->message = 'deleted';
        $this->objectType = get_class($unit);
        $this->objectId = $unit->id;
    }
}

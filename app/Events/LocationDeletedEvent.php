<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use App\Models\Location;


class LocationDeletedEvent
{
    use Dispatchable, SerializesModels;

    public $location;
    public $message;
    public $objectType;
    public $objectId;

    /**
     * locationEvent constructor.
     * @param location $location
     */
    public function __construct(Location $location)
    {
        $this->location = $location;
        $this->message = 'deleted';
        $this->objectType = get_class($location);
        $this->objectId = $location->id;
    }

}

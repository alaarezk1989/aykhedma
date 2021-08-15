<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use App\Models\Location;


class LocationUpdatedEvent
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
        $this->message = 'updated';
        if ($location->wasChanged('active')) {
            $status = $location->active ? 'active' : 'disabled';
            $this->message = 'changed_status_to_' . $status;
        }

        $this->objectType = get_class($location);
        $this->objectId = $location->id;

    }

}

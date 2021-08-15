<?php


namespace App\Events;

use App\Models\Activity;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class ActivityCreatedEvent
{
    use Dispatchable , SerializesModels;
    public $activity;
    public $message;
    public $objectType;
    public $objectId;

    /**
     * ActivityEditedEvent constructor.
     * @param Activity $Activity
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
        $this->message = 'created'; 
        $this->objectType = get_class($activity);
        $this->objectId = $activity->id;
    }
}

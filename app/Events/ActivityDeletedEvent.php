<?php


namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use App\Models\Activity;

class ActivityDeletedEvent
{
    use Dispatchable, SerializesModels;

    public $activity;
    public $message;
    public $objectType;
    public $objectId;

    /**
     * ActivityEvent constructor.
     * @param Activity $Activity
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
        $this->message = 'deleted';
        $this->objectType = get_class($activity);
        $this->objectId = $activity->id;
    }
}

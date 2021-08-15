<?php


namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use App\Models\Activity;

class ActivityEditedEvent
{
    use Dispatchable, SerializesModels;

    public $activity;
    public $message;
    public $objectType;
    public $objectId;

    /**
     * ProductEvent constructor.
     * @param Activity $Activity
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
        $this->message = 'updated';
        if ($activity->wasChanged('active')) {
            $status = $activity->active ? 'active' : 'disabled';
            $this->message = 'changed_status_to_' . $status;
        }

        $this->objectType = get_class($activity);
        $this->objectId = $activity->id;
    }


}

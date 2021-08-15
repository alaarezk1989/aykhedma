<?php

namespace App\Events;

use App\Models\Review;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class VendorReviewsEditedEvent
{
    use Dispatchable, SerializesModels;

    public $review;
    public $message;
    public $objectType;
    public $objectId;

    /**
     * VendorReviewsEditedEvent constructor.
     * @param Review $review
     */
    public function __construct(Review $review)
    {
        $this->review = $review;
        $this->message = 'updated';
        if ($review->wasChanged('published')) {
            $status = $review->published ? 'published' : 'unpublished';
            $this->message = 'changed_status_to_' . $status;
        }
        $this->objectType = get_class($review);
        $this->objectId = $review->id;
    }
}

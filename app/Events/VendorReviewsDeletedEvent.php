<?php

namespace App\Events;

use App\Models\Review;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class VendorReviewsDeletedEvent
{
    use Dispatchable, SerializesModels;

    public $review;
    public $message;
    public $objectType;
    public $objectId;

    /**
     * VendorReviewsDeletedEvent constructor.
     * @param Review $review
     */
    public function __construct(Review $review)
    {
        $this->review = $review;
        $this->message = 'deleted';
        $this->objectType = get_class($review);
        $this->objectId = $review->id;
    }
}

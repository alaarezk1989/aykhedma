<?php

namespace App\Events;

use App\Models\Review;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class VendorReviewsCreatedEvent
{
    use Dispatchable, SerializesModels;

    public $review;
    public $message;
    public $objectType;
    public $objectId;

    /**
     * VendorReviewsCreatedEvent constructor.
     * @param Review $review
     */
    public function __construct(Review $review)
    {
        $this->review = $review;
        $this->message = 'created';
        $this->objectType = get_class($review);
        $this->objectId = $review->id;
    }
}

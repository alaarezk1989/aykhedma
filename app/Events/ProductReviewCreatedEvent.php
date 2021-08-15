<?php


namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use App\Models\ProductReview;

class ProductReviewCreatedEvent
{
    use Dispatchable, SerializesModels;

    public $productReview;
    public $message;
    public $objectType;
    public $objectId;

    /**
     * ProductReviewCreatedEvent constructor.
     * @param ProductReview $productReview
     */
    public function __construct(ProductReview $productReview)
    {
        $this->productReview = $productReview;
        $this->message = 'created';
        $this->objectType = get_class($productReview);
        $this->objectId = $productReview->id;
    }


}

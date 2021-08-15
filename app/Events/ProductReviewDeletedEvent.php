<?php


namespace App\Events;

use App\Models\ProductReview;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class ProductReviewDeletedEvent
{
    use Dispatchable, SerializesModels;

    public $productReview;
    public $message;
    public $objectType;
    public $objectId;

    /**
     * ProductReviewDeletedEvent constructor.
     * @param ProductReview $productReview
     */
    public function __construct(ProductReview $productReview)
    {
        $this->productReview = $productReview;
        $this->message = 'deleted';
        $this->objectType = get_class($productReview);
        $this->objectId = $productReview->id;
    }
}

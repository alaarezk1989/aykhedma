<?php


namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use App\Models\ProductReview;

class ProductReviewEditedEvent
{
    use Dispatchable, SerializesModels;

    public $productReview;
    public $message;
    public $objectType;
    public $objectId;

    /**
     * ProductReviewEditedEvent constructor.
     * @param ProductReview $productReview
     */
    public function __construct(ProductReview $productReview)
    {
        $this->productReview = $productReview;
        $this->message = 'updated';
        if ($productReview->wasChanged('published')) {
            $status = $productReview->published ? 'published' : 'unpublished';
            $this->message = 'changed_status_to_' . $status;
        }

        $this->objectType = get_class($productReview);
        $this->objectId = $productReview->id;
    }


}
